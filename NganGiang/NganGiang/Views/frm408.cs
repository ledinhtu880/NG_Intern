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
using FontAwesome.Sharp;


namespace NganGiang.Views
{
    public partial class frm408 : Form
    {
        Station408_Controller packController { get; set; }
        List<int> listContentPack = new List<int>();
        public frm408()
        {
            InitializeComponent();
            packController = new Station408_Controller();
        }
        public void loadData()
        {
            packController.Show(dgv408);
            // Vòng lặp qua các cột trong DataGridView và tắt sắp xếp

            if (!dgv408.Columns.Contains("XemChiTietColumn"))
            {
                DataGridViewImageColumn btnColumn = new DataGridViewImageColumn();
                btnColumn.HeaderText = "Xem chi tiết";
                btnColumn.Name = "XemChiTietColumn";
                dgv408.Columns.Add(btnColumn);
            }

            foreach (DataGridViewColumn column in dgv408.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }
        }

        private void frm408_Load(object sender, EventArgs e)
        {
            loadData();
        }

        private void dgv408_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
            if (dgv408.Columns[e.ColumnIndex].Name.Equals("XemChiTietColumn"))
            {
                string imagePath = Path.Combine("..", "..", "..", "Resources", "eye-solid.png");
                if (File.Exists(imagePath))
                {
                    Image image = Image.FromFile(imagePath);
                    e.Value = image;
                }
            }
        }

        private void dgv408_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex >= 0 && e.ColumnIndex == dgv408.Columns["XemChiTietColumn"].Index)
            {
                string id = dgv408.Rows[e.RowIndex].Cells["Mã gói hàng"].Value.ToString();

                detailContentPack detailForm = new detailContentPack();
                detailForm.SetContentPackID(id);
                detailForm.Show();
            }
        }

        private void btnProcess_Click(object sender, EventArgs e)
        {
            foreach (DataGridViewRow rows in dgv408.Rows)
            {
                if (Convert.ToBoolean(rows.Cells[0].Value) == true)
                {
                    listContentPack.Add(Convert.ToInt32(rows.Cells["Mã gói hàng"].Value.ToString()));
                }
            }
            if (listContentPack.Count > 0)
            {
                bool flag = false;
                if (MessageBox.Show("Bạn chắc chắn muốn đóng gói hàng?", "Xác nhận hành động", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    foreach (var item in listContentPack)
                    {
                        if (packController.Update(item))
                        {
                            flag = true;
                        }
                        else
                        {
                            flag = false;
                            break;
                        }
                    }
                    if (flag)
                    {
                        MessageBox.Show("Xử lý thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    }
                    else
                    {
                        listContentPack.Clear();
                    }
                    loadData();
                }
            }
            else
            {
                MessageBox.Show("Bạn chưa chọn nội dung sản xuất!", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }
    }
}
