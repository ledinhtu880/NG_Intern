using FontAwesome.Sharp;
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
    public partial class frm409 : Form
    {
        Station409_Controller packController { get; set; }
        List<int> listContentPack = new List<int>();
        Point[] points;
        public frm409()
        {
            InitializeComponent();
            packController = new Station409_Controller();
        }
        public void loadData()
        {
            packController.Show(dgv409);
            // Vòng lặp qua các cột trong DataGridView và tắt sắp xếp
            DataGridViewImageColumn btnColumn = new DataGridViewImageColumn();
            btnColumn.HeaderText = "Xem chi tiết";
            btnColumn.Name = "XemChiTietColumn";

            dgv409.Columns.Add(btnColumn);

            foreach (DataGridViewColumn column in dgv409.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }
            updateDGVWareHouse();
        }
        private void frm409_Load(object sender, EventArgs e)
        {
            loadData();
        }
        private void updateDGVWareHouse()
        {
            dgvWare.Rows.Clear();
            dgvWare.Columns.Clear();
            int row = packController.getRowAndCol(out int col);

            if (row == 0 || col == 0)
            {
                MessageBox.Show("Kho chưa được thiết lập", "Chú ý", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            DataTable dt = packController.getMatrix();
            int[] Id_PackContents = new int[dt.Rows.Count];
            int[] Count_Containers = new int[dt.Rows.Count];
            int[] ro = new int[dt.Rows.Count];
            int[] co = new int[dt.Rows.Count];
            points = new Point[dt.Rows.Count];

            if (dt.Rows.Count > 0)
            {
                for (int i = 0; i < dt.Rows.Count; i++)
                {
                    ro[i] = Int32.Parse(dt.Rows[i]["Rowi"].ToString());
                    co[i] = Int32.Parse(dt.Rows[i]["Colj"].ToString());
                    Id_PackContents[i] = Int32.Parse(dt.Rows[i]["Id_ContentPack"].ToString());
                    Count_Containers[i] = Int32.Parse(dt.Rows[i]["SoLuong"].ToString());
                }
            }
            dgvWare.RowTemplate.Height = 150;

            for (int i = 0; i <= col; i++)
            {
                DataGridViewColumn column = new DataGridViewTextBoxColumn();
                column.Name = "Column" + i.ToString();
                if (i == 0)
                {
                    column.Width = 50;
                    column.HeaderText = "STT";
                    column.ReadOnly = true;
                    dgvWare.Columns.Add(column);
                    continue;
                }
                column.Width = 150;
                column.HeaderText = i.ToString();
                dgvWare.Columns.Add(column);
            }

            for (int i = 0; i < row; i++)
            {
                dgvWare.Rows.Add();
                dgvWare.Rows[i].Cells[0].Value = i + 1;
            }
            int count = 0;
            for (int r = 0; r < row; r++)
            {
                // r bắt đầu từ 0
                for (int c = 1; c <= col; c++)
                {
                    // c bắt đầu từ 1
                    if (r <= ro.Length && c <= co.Length && ro.Length > 0 && co.Length > 0)
                    {
                        if (ro.Length - 1 >= r && co.Length >= c && ro[r] == r + 1 && co[c - 1] == c)
                        {
                            DataGridViewButtonCell buttonCell = new DataGridViewButtonCell();
                            buttonCell.Value = $"Gói hàng số {Id_PackContents[count]}\nSố lượng {Count_Containers[count]}";
                            dgvWare["Column" + c.ToString(), r].ReadOnly = false;
                            points[count] = new Point(c, r);
                            count++;
                            dgvWare["Column" + c.ToString(), r] = buttonCell;
                        }
                        else
                        {
                            dgvWare["Column" + c.ToString(), r].Value = "Trống";
                            dgvWare["Column" + c.ToString(), r].ReadOnly = true;
                        }
                    }
                    else
                    {
                        dgvWare["Column" + c.ToString(), r].Value = "Trống";
                        dgvWare["Column" + c.ToString(), r].ReadOnly = true;
                    }
                }
            }
        }
        private void btnProcess_Click(object sender, EventArgs e)
        {
            listContentPack.Clear();
            foreach (DataGridViewRow rows in dgv409.Rows)
            {
                if (Convert.ToBoolean(rows.Cells[0].Value) == true)
                {
                    listContentPack.Add(Convert.ToInt32(rows.Cells[2].Value));
                }
            }
            if (listContentPack.Count > 0)
            {
                bool flag = false;
                if (MessageBox.Show("Bạn chắc chắn muốn lưu các gói hàng trên vào kho?", "Xác nhận hành động", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    foreach (var item in listContentPack)
                    {
                        if (packController.Update(item))
                        {
                            flag = true;
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
        private void dgv409_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            DataTable dt = packController.getMatrix();
            if (e.RowIndex >= 0 && e.ColumnIndex >= 0 && dgv409[e.ColumnIndex, e.RowIndex] is DataGridViewButtonCell)
            {
                Point pos = new Point(e.ColumnIndex, e.RowIndex);
                int row = pos.Y + 1;
                int col = pos.X;
                foreach (DataRow r in dt.Rows)
                {
                    if (Int32.Parse(r["Rowi"].ToString()) == row && Int32.Parse(r["Colj"].ToString()) == col)
                    {

                        string id = dgv409.Rows[e.RowIndex].Cells["Id_ContentPack"].Value.ToString();

                        detailContentPack detailForm = new detailContentPack();
                        detailForm.SetContentPackID(id);
                        detailForm.Show();
                        return;
                    }
                }
                return;
            }
        }
        private void dgv409_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
            if (dgv409.Columns[e.ColumnIndex].Name.Equals("XemChiTietColumn"))
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
