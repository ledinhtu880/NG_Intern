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
    public partial class frm405 : Form
    {
        private Station405_Controller processController { get; set; }
        List<ContentSimple> listContentSimple = new List<ContentSimple>();
        PLCService plcService { get; set; }
        bool isPLCReady = false;
        public frm405()
        {
            InitializeComponent();
            processController = new Station405_Controller();
            plcService = new PLCService();
        }

        private void frm405_Load(object sender, EventArgs e)
        {
            LoadData();
        }
        private void LoadData()
        {
            if (dgv405.Rows.Count > 0)
            {
                dgv405.Columns.Clear();
                dgv405.DataSource = null;
            }
            processController.DisplayListOrderProcess(dgv405);
        }

        private void dgv405_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
            if (e.ColumnIndex == 2 && e.Value is bool)
            {
                bool cellValue = Convert.ToBoolean(e.Value);
                string stringValue = cellValue ? "Gói hàng" : "Thùng hàng";

                e.Value = stringValue;
                e.FormattingApplied = true;
            }
            if (e.ColumnIndex == 10)
            {
                DateTime date_start = Convert.ToDateTime(e.Value);
                string formattedDate = date_start.ToString("dd-MM-yyyy");

                e.Value = formattedDate;
                e.FormattingApplied = true;
            }
        }

        private void dgv405_ColumnAdded(object sender, DataGridViewColumnEventArgs e)
        {
            e.Column.SortMode = DataGridViewColumnSortMode.NotSortable;
        }

        private void btnProcess_Click(object sender, EventArgs e)
        {
            if (!isPLCReady)
            {
                MessageBox.Show("PLC chưa sẵn sàng", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }
            listContentSimple.Clear();
            foreach (DataGridViewRow row in dgv405.Rows)
            {
                if (Convert.ToBoolean(row.Cells[0].Value) == true)
                {
                    string rfidBase64 = processController.getRFID(Convert.ToInt32(row.Cells["Id_Simple"].Value));

                    ContentSimple contentSimple = new ContentSimple();
                    contentSimple.Id_ContentSimple = Convert.ToInt32(row.Cells["Id_Simple"].Value);
                    contentSimple.Count_Container = Convert.ToInt32(row.Cells["Count_Container"].Value);
                    contentSimple.FK_Id_ContainerType = Convert.ToInt32(row.Cells["FK_Id_ContainerType"].Value);
                    contentSimple.RFID = rfidBase64;

                    listContentSimple.Add(contentSimple);
                }
            }

            if (listContentSimple.Count > 0)
            {
                DialogResult confirm = MessageBox.Show("Bạn chắc chắn muốn cấp nắp thùng cho các thùng hàng trên?", "Xác nhận hành động", MessageBoxButtons.OKCancel, MessageBoxIcon.Question);
                if (confirm == DialogResult.OK)
                {
                    foreach (var item in listContentSimple)
                    {
                        int id_content_simple = Convert.ToInt32(item.Id_ContentSimple);
                        if (!processController.checkQuantity(id_content_simple))
                        {
                            MessageBox.Show($"Số lượng nắp thùng cấp cho thùng hàng {id_content_simple} không đủ! Vui lòng thử lại sau", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
                            LoadData();
                            return;
                        }

                        plcService.sendTo405(item.FK_Id_ContainerType, item.Count_Container, item.RFID);

                        if (processController.UpdateStateSimple(Convert.ToInt32(item.Id_ContentSimple), 1, 405))
                        {
                            DataGridViewRow row = dgv405.Rows.Cast<DataGridViewRow>().FirstOrDefault(r => Convert.ToDecimal(r.Cells["id_simple"].Value) == item.Id_ContentSimple);

                            if (row != null)
                            {
                                row.Cells["status"].Value = "Đang xử lý";
                            }
                        }

                        while (true)
                        {
                            bool isAcknowledged = plcService.CheckAcknowledgment();

                            if (isAcknowledged)
                            {
                                byte[] rfidBytes = Convert.FromBase64String(plcService.getRFIDFromPLC());
                                processController.UpdateCoverHatProvided(id_content_simple);

                                break;
                            }
                        }
                        plcService.updateStatus();
                    }
                    MessageBox.Show("Cấp nắp thùng thành công!", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
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
