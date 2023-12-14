using NganGiang.Controllers;
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
        List<int> listContentSimple = new List<int>();
        public frm403()
        {
            InitializeComponent();
            simpleController = new Station403_Controller();
        }

        private void btnProcess_Click(object sender, EventArgs e)
        {
            listContentSimple.Clear();
            foreach (DataGridViewRow rows in dgv403.Rows)
            {
                if (Convert.ToBoolean(rows.Cells[0].Value) == true)
                {
                    listContentSimple.Add(Convert.ToInt32(rows.Cells[3].Value));
                }
            }
            if (listContentSimple.Count > 0)
            {
                if (MessageBox.Show("Bạn chắc chắn muốn rót nguyên liệu lỏng vào thùng hàng?", "Xác nhận hành động", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
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
            dgv403.Columns[7].FillWeight = 70;
            dgv403.Columns[8].FillWeight = 70;
            dgv403.Columns[9].FillWeight = 70;
            // Vòng lặp qua các cột trong DataGridView và tắt sắp xếp
            foreach (DataGridViewColumn column in dgv403.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }
        }

        private void dgv403_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
            if (e.ColumnIndex == 9) // Kiểm tra cột "Ngày bắt đầu"
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
        }
    }
}
