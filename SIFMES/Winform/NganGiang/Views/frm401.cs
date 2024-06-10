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
    public partial class frm401 : Form
    {
        Station401_Controller processController { get; set; }
        PLCService plcService { get; set; }
        List<ContentSimple> chk = new List<ContentSimple>();

        public frm401()
        {
            InitializeComponent();
            processController = new Station401_Controller();
            plcService = new PLCService();
        }
        private void LoadData()
        {
            if (dgv401.Rows.Count > 0)
            {
                dgv401.Columns.Clear();
                dgv401.DataSource = null;
            }
            processController.DisplayListOrderProcess(dgv401);
        }
        private void btnProcess_Click(object sender, EventArgs e)
        {
            chk.Clear();
            foreach (DataGridViewRow row in dgv401.Rows)
            {
                if (Convert.ToBoolean(row.Cells[0].Value) == true)
                {
                    byte[] rfidBytes = processController.GenerateRandomBytes(16);

                    string rfidBase64 = Convert.ToBase64String(rfidBytes);

                    ContentSimple contentSimple = new ContentSimple();
                    contentSimple.Id_ContentSimple = Convert.ToInt32(row.Cells["id_simple"].Value);
                    contentSimple.Count_Container = Convert.ToInt32(row.Cells["quantity_order"].Value);
                    contentSimple.FK_Id_RawMaterial = Convert.ToInt32(row.Cells["FK_Id_RawMaterial"].Value);
                    contentSimple.FK_Id_ContainerType = Convert.ToInt32(row.Cells["FK_Id_ContainerType"].Value);
                    contentSimple.RFID = rfidBase64;

                    chk.Add(contentSimple);
                }
            }
            if (chk.Count > 0)
            {
                DialogResult confirm = MessageBox.Show("Bạn chắc chắn muốn cấp thùng chứa và đế dán mã RFID cho các thùng hàng trên?", "Xác nhận hành động", MessageBoxButtons.OKCancel, MessageBoxIcon.Question);
                if (confirm == DialogResult.OK)
                {
                    foreach (var item in chk)
                    {
                        int id_content_simple = Convert.ToInt32(item.Id_ContentSimple);

                        if (!processController.checkQuantityContainer(id_content_simple))
                        {
                            MessageBox.Show($"Số lượng nguyên liệu thùng chứa cấp cho thùng hàng {id_content_simple} không đủ! Vui lòng thử lại sau.", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                            return;
                        }
                        else if (!processController.checkQuantityPedestal(id_content_simple))
                        {
                            MessageBox.Show($"Số lượng nguyên liệu đế cấp cho thùng hàng {id_content_simple} không đủ! Vui lòng thử lại sau.", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                            return;
                        }

                        plcService.sendTo401(id_content_simple, item.FK_Id_RawMaterial, item.FK_Id_ContainerType, item.Count_Container, item.RFID);

                        if (processController.UpdateState(Convert.ToInt32(item.Id_ContentSimple), 1))
                        {
                            DataGridViewRow row = dgv401.Rows.Cast<DataGridViewRow>().FirstOrDefault(r => Convert.ToDecimal(r.Cells["id_simple"].Value) == item.Id_ContentSimple);

                            if (row != null)
                            {
                                row.Cells["Unit"].Value = "Đang xử lý";
                            }
                        }

                        while (true)
                        {
                            bool isAcknowledged = plcService.CheckAcknowledgment();

                            if (isAcknowledged)
                            {
                                byte[] rfidBytes = Convert.FromBase64String(plcService.getRFIDFromPLC());
                                processController.UpdateQuantity(item.Count_Container);
                                processController.UpdateProcessAndSimple(id_content_simple, rfidBytes);

                                break;
                            }
                        }

                        plcService.updateStatus();
                    }

                    MessageBox.Show("Cấp thùng chứa và đế dán mã RFID thành công!", "", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    LoadData();
                }
            }
            else
            {
                MessageBox.Show("Bạn chưa chọn nội dung sản xuất!", "", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }
        private void dgv401_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
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
                if (e.Value != null && e.Value != DBNull.Value)
                {
                    DateTime date;
                    if (DateTime.TryParse(e.Value.ToString(), out date))
                    {
                        e.Value = date.ToString("dd/MM/yyyy");
                        e.FormattingApplied = true;
                    }
                }
            }
        }
        private void frm401_Load(object sender, EventArgs e)
        {
            LoadData();
        }
    }
}
