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
    public partial class frm403 : Form
    {
        Station403_Controller simpleController { get; set; }
        PLCService plcService { get; set; }
        bool isPLCReady = false;
        public frm403()
        {
            InitializeComponent();
            simpleController = new Station403_Controller();
            plcService = new PLCService();
        }
        private void btnProcess_Click(object sender, EventArgs e)
        {
            List<ContentSimple> listContentSimple = new List<ContentSimple>();
            listContentSimple.Clear();
            foreach (DataGridViewRow row in dgv403.Rows)
            {
                if (Convert.ToBoolean(row.Cells[0].Value) == true)
                {
                    string rfidBase64 = simpleController.getRFID(Convert.ToInt32(row.Cells["Mã thùng hàng"].Value));
                    ContentSimple contentSimple = new ContentSimple();
                    contentSimple.Id_ContentSimple = Convert.ToInt32(row.Cells["Mã thùng hàng"].Value);
                    contentSimple.Count_Container = Convert.ToInt32(row.Cells["Số lượng thùng chứa"].Value);
                    contentSimple.FK_Id_RawMaterial = Convert.ToInt32(row.Cells["Loại nguyên liệu"].Value);
                    contentSimple.FK_Id_ContainerType = Convert.ToInt32(row.Cells["Loại thùng chứa"].Value);
                    contentSimple.RFID = rfidBase64;
                    listContentSimple.Add(contentSimple);
                }
            }
            if (listContentSimple.Count > 0)
            {
                if (MessageBox.Show("Bạn chắc chắn muốn rót nguyên liệu lỏng vào thùng hàng?", "Xác nhận hành động", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    foreach (var item in listContentSimple)
                    {
                        int Id_ContentSimple = Convert.ToInt32(item.Id_ContentSimple);
                        if (!simpleController.checkQuantity(Id_ContentSimple))
                        {
                            MessageBox.Show($"Số lượng nguyên liệu cho thùng hàng {item.Id_ContentSimple} không đủ! Vui lòng thử lại sau", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                            return;
                        }
                        plcService.sendTo403(item.FK_Id_RawMaterial, item.FK_Id_ContainerType, item.Count_Container, item.RFID);
                        if (simpleController.UpdateStateSimple(Convert.ToInt32(item.Id_ContentSimple), 1, 403))
                        {
                            DataGridViewRow row = dgv403.Rows.Cast<DataGridViewRow>().FirstOrDefault(r => Convert.ToDecimal(r.Cells["Mã thùng hàng"].Value) == item.Id_ContentSimple);
                            if (row != null)
                            {
                                row.Cells["Trạng thái"].Value = "Đang xử lý";
                            }
                        }
                        while (true)
                        {
                            bool isAcknowledged = plcService.CheckAcknowledgment();
                            if (isAcknowledged)
                            {
                                simpleController.Update(Id_ContentSimple);
                                break;
                            }
                        }
                        plcService.updateStatus();
                    }
                    MessageBox.Show("Rót nguyên liệu thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    loadData();
                }
            }
            else
            {
                MessageBox.Show("Bạn chưa chọn nội dung sản xuất!", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }
        private void frm403_Load(object sender, EventArgs e)
        {
            loadData();
        }
        public void loadData()
        {
            simpleController.Show(dgv403);
            foreach (DataGridViewColumn column in dgv403.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
                column.Frozen = false;
                if (column.Name == "Loại nguyên liệu" || column.Name == "Số lượng thùng chứa" || column.Name == "Loại thùng chứa")
                {
                    column.Visible = false;
                }
                if (column.Name == "Số lượng nguyên liệu tồn" || column.Name == "Số lượng nguyên liệu cần")
                {
                    column.AutoSizeMode = DataGridViewAutoSizeColumnMode.Fill;
                }
                else
                {
                    column.AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells;
                }
            }
        }
        private void dgv403_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
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
