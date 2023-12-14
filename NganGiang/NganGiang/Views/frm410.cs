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
    public partial class frm410 : Form
    {
        private Station410_Controller controller;
        public frm410()
        {
            InitializeComponent();
            controller = new Station410_Controller();

        }

        private void btnProcess_Click(object sender, EventArgs e)
        {
            List<decimal> listIdPackContents = new List<decimal>();
            bool check = false;
            // Kiểm tra xem checkbox đã được check hay chưa
            foreach (DataGridViewRow row in dgv410.Rows)
            {
                if (row != null)
                {
                    DataGridViewCheckBoxCell? cell = row.Cells["IsSelected"] as DataGridViewCheckBoxCell;
                    if (cell != null && cell.Value is bool)
                    {
                        // Nếu checkbox được check thì thêm Id_PackContent vào danh sách
                        if ((Boolean)cell.Value)
                        {
                            listIdPackContents.Add(Convert.ToDecimal(row.Cells["FK_Id_ContentPack"].Value));
                            check = true;
                        }
                    }
                }
            }

            if (check)
            {
                if (MessageBox.Show("Bạn chắc chắn muốn quấn màng PE các gói trên?", "Xác nhận hành động", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    string message = "";
                    bool result = controller.processAt410(listIdPackContents, out message);
                    if (result)
                    {
                        MessageBox.Show("Quấn màng thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
                        this.LoadData();
                    }
                    else
                    {
                        MessageBox.Show(message, "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    }
                }
            }
            else
            {
                MessageBox.Show("Vui lòng chọn ít nhất 1 dòng", "Chú ý", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }
        }

        private void frm410_Load(object sender, EventArgs e)
        {
            this.LoadData();

            foreach (DataGridViewColumn column in dgv410.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }

            DataGridViewImageColumn imageColumn = new DataGridViewImageColumn();
            imageColumn.Name = "btnShowInfor";
            imageColumn.HeaderText = "Xem chi tiết";
            dgv410.Columns.Add(imageColumn);
        }
        private void LoadData()
        {
            DataTable dt = controller.getProcessAt410();
            dgv410.DataSource = dt;
        }

        private void dgv410_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.ColumnIndex == dgv410.Columns["btnShowInfor"].Index && e.RowIndex >= 0)
            {
                decimal Id_SimpleContent = Convert.ToDecimal(dgv410.Rows[e.RowIndex].Cells["FK_Id_ContentPack"].Value);
                DataTable displayInfoOrder = controller.getInforSimpleContentBySimplePack(Id_SimpleContent);
                detailContentSimple dio = new detailContentSimple(displayInfoOrder, Id_SimpleContent);
                dio.ShowDialog();
            }
        }

        private void dgv410_CellMouseEnter(object sender, DataGridViewCellEventArgs e)
        {
            if (e.ColumnIndex == dgv410.Columns["btnShowInfor"].Index && e.RowIndex >= 0)
            {
                // Thay đổi màu của image thành màu đỏ
                DataGridViewCell cell = dgv410.Rows[e.RowIndex].Cells[e.ColumnIndex];
                if (cell != null)
                {
                    cell.Style.BackColor = Color.FromArgb(132, 145, 165);
                }
            }
        }

        private void dgv410_CellMouseLeave(object sender, DataGridViewCellEventArgs e)
        {
            if (e.ColumnIndex == dgv410.Columns["btnShowInfor"].Index && e.RowIndex >= 0)
            {
                // Thay đổi màu của image thành màu đỏ
                DataGridViewCell cell = dgv410.Rows[e.RowIndex].Cells[e.ColumnIndex];
                if (cell != null)
                {
                    cell.Style.BackColor = Color.White;
                }
            }
        }
        private void dgv410_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
            if (dgv410.Columns[e.ColumnIndex].Name.Equals("btnShowInfor"))
            {
                string imagePath = Path.Combine("..", "..", "..", "Resources", "eye-solid.png");
                if (File.Exists(imagePath))
                {
                    Image image = Image.FromFile(imagePath);
                    e.Value = image;
                }
            }
        }
    }
}
