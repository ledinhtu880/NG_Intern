using NganGiang.Services;
using System.Data;
using System.Data.Common;
using System.Data.SqlClient;
using System.Reflection.Metadata;
using System.Windows.Forms;
using System.Drawing;
using NganGiang.Controllers;

namespace NganGiang
{
    public partial class frmMain : Form
    {
        ProcessContentSimpleController simpleController { get; set; }
        List<int> listContentSimple = new List<int>();
        public frmMain()
        {
            InitializeComponent();
            simpleController = new ProcessContentSimpleController();
        }
        public void loadData()
        {
            simpleController.Show(dgv403);
        }
        private void frmMain_Load(object sender, EventArgs e)
        {
            loadData();
        }
        private void btnProcess_Click(object sender, EventArgs e)
        {
            listContentSimple.Clear();
            foreach (DataGridViewRow rows in dgv403.Rows)
            {
                if (Convert.ToBoolean(rows.Cells[0].Value) == true)
                {
                    listContentSimple.Add(Convert.ToInt32(rows.Cells[2].Value));
                }
            }
            if (listContentSimple.Count > 0)
            {
                bool flag = false;
                foreach (var item in listContentSimple)
                {
                    if (simpleController.Update(item))
                    {
                        flag = true;
                    }
                    else
                    {
                        MessageBox.Show($"Kho không có đủ số lượng cho thùng hàng số {item}", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                    }
                }
                if (flag)
                {
                    MessageBox.Show("Xử lý thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    loadData();
                }
            }
            else
            {
                MessageBox.Show("Bạn chưa chọn nội dung sản xuất!", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }
        private void dgv403_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
            if (e.ColumnIndex == 5) // Kiểm tra cột "Ngày bắt đầu"
            {
                if (e.Value != null && e.Value != DBNull.Value)
                {
                    DateTime date;
                    if (DateTime.TryParse(e.Value.ToString(), out date))
                    {
                        e.Value = date.ToString("dd/MM/yyyy");
                        e.FormattingApplied = true; // Đánh dấu đã áp dụng định dạng
                    }
                }
            }
            if (e.ColumnIndex == 6) // Kiểm tra cột "Ngày kết thúc"
            {
                if (e.Value == null || string.IsNullOrWhiteSpace(e.Value.ToString()))
                {
                    e.Value = "Chưa hoàn thành";
                    e.FormattingApplied = true; // Đánh dấu đã áp dụng định dạng
                }
                else if (e.Value != null && e.Value != DBNull.Value)
                {
                    DateTime date;
                    if (DateTime.TryParse(e.Value.ToString(), out date))
                    {
                        e.Value = date.ToString("dd/MM/yyyy");
                        e.FormattingApplied = true; // Đánh dấu đã áp dụng định dạng
                    }
                }
            }
        }
    }
}