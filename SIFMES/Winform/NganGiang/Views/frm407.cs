using NganGiang.Controllers;
using NganGiang.Models;
using NganGiang.Services;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace NganGiang.Views
{
    public partial class frm407 : Form
    {
        private Station407_Controller processController { get; set; }
        List<ContentSimple> listContentSimple = new List<ContentSimple>();
        PLCService plcService { get; set; }
        bool isPLCReady = false;
        public frm407()
        {
            InitializeComponent();
            processController = new Station407_Controller();
            plcService = new PLCService();
        }
        private void Process407_Load(object sender, EventArgs e)
        {
            LoadData();
        }

        private void LoadData()
        {
            if (dgv407.Rows.Count > 0)
            {
                dgv407.Columns.Clear();
                dgv407.DataSource = null;
            }
            processController.DisplayListOrderProcess(dgv407);
        }
        private void dgv407_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
            if (e.ColumnIndex == 2 && e.Value is bool)
            {
                bool cellValue = Convert.ToBoolean(e.Value);
                string stringValue = cellValue ? "Gói hàng" : "Thùng hàng";

                e.Value = stringValue;
                e.FormattingApplied = true;
            }
            if (e.ColumnIndex == 9)
            {
                DateTime date_start = Convert.ToDateTime(e.Value);
                string formattedDate = date_start.ToString("dd-MM-yyyy");

                e.Value = formattedDate;
                e.FormattingApplied = true;
            }
        }
        private void dgv407_ColumnAdded(object sender, DataGridViewColumnEventArgs e)
        {
            e.Column.SortMode = DataGridViewColumnSortMode.NotSortable;
        }
        private void btnProcess_Click(object sender, EventArgs e)
        {
            listContentSimple.Clear();
            if (!isPLCReady)
            {
                MessageBox.Show("PLC chưa sẵn sàng", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            foreach (DataGridViewRow row in dgv407.Rows)
            {
                if (Convert.ToBoolean(row.Cells[0].Value) == true)
                {
                    ContentSimple item = new ContentSimple();
                    item.Id_ContentSimple = Convert.ToInt32(row.Cells[3].Value);
                    item.RFID = processController.getRFID(Convert.ToInt32(row.Cells[3].Value));
                    listContentSimple.Add(item);
                }
            }
            if (listContentSimple.Count > 0)
            {
                DialogResult confirm = MessageBox.Show("Bạn chắc chắn muốn dán nhãn cho các thùng hàng trên?", "Xác nhận hành động", MessageBoxButtons.OKCancel, MessageBoxIcon.Question);
                if (confirm == DialogResult.OK)
                {
                    foreach (ContentSimple item in listContentSimple)
                    {
                        int id_content_simple = Convert.ToInt32(item.Id_ContentSimple);
                        /*if (processController.isInternalCustomer(id_content_simple))
                        {
                            if (!processController.IsOutOfStockContainer(id_content_simple))
                            {
                                MessageBox.Show($"Số lượng thùng chứa trong kho 406 của thùng số {id_content_simple} vẫn còn dư.", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                                return;
                            }
                        }*/

                        plcService.sendTo407(item.RFID);

                        if (processController.UpdateStateSimple(Convert.ToInt32(item.Id_ContentSimple), 1, 407))
                        {
                            DataGridViewRow row = dgv407.Rows.Cast<DataGridViewRow>().FirstOrDefault(r => Convert.ToDecimal(r.Cells["Id_Simple"].Value) == item.Id_ContentSimple);

                            if (row != null)
                            {
                                row.Cells["Status"].Value = "Đang xử lý";
                            }
                        }

                        while (true)
                        {
                            bool isAcknowledged = plcService.CheckAcknowledgment();

                            // Nếu là thùng hàng trong gói hàng thì sẽ sử dụng hàm UpdateAndInsertProcessPack, 
                            /*if (isAcknowledged)
                            {
                                if (processController.isInternalCustomer(id_content_simple))
                                {
                                    if (processController.IsLastStation(id_content_simple))
                                    {
                                        processController.UpdateProcessAndOrder(id_content_simple);
                                    }
                                    *//*else
                                    { 
                                        processController.UpdateAndInsertProcessSimple(id_content_simple);
                                        processController.UpdateAndInsertProcessPack(id_content_simple);
                                    }*//*
                                }
                                else
                                {
                                    if (processController.IsLastStation(id_content_simple))
                                    {
                                        processController.UpdateQrCodeAndState(id_content_simple);
                                        processController.UpdateProcessAndOrder(id_content_simple);
                                    }
                                    *//*else
                                    {
                                        processController.UpdateAndInsertProcessSimple(id_content_simple);
                                        processController.UpdateAndInsertProcessPack(id_content_simple);
                                    }*//*
                                }*/
                            if (isAcknowledged)
                            {
                                bool isInternalCustomer = processController.isInternalCustomer(id_content_simple);
                                bool isLastStation = processController.IsLastStation(id_content_simple);

                                if (isLastStation)
                                {
                                    if (!isInternalCustomer)
                                    {
                                        processController.UpdateQrCodeAndState(id_content_simple);
                                    }
                                    processController.UpdateProcessAndOrder(id_content_simple);
                                }
                                break;
                            }
                        }
                        plcService.updateStatus();
                    }
                    MessageBox.Show("Dán nhãn và xuất phiếu giao thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    LoadData();
                }
            }
            else
            {
                MessageBox.Show("Bạn chưa chọn nội dung sản xuất!", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }

        private void timer1_Tick(object sender, EventArgs e)
        {
            if (plcService.getSignal() && !isPLCReady)
            {
                isPLCReady = true;
                timer1.Enabled = false;
                MessageBox.Show("PLC đã sẵn sàng", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
        }
    }
}
