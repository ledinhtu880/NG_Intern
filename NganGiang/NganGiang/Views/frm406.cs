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
    public partial class frm406 : Form
    {
        private Station406_Controller controller;
        Point[] points;
        public frm406()
        {
            InitializeComponent();
            controller = new Station406_Controller();
        }
        private void frm406_Load(object sender, EventArgs e)
        {
            updateDGV();
        }

        private void updateDGV()
        {
            dgv406.DataSource = controller.getProcessAt406();
            updateDGVWareHouse();
        }

        private void updateDGVWareHouse()
        {
            dgv_ware.Rows.Clear();
            dgv_ware.Columns.Clear();
            int row = controller.getRowAndCol(out int col);

            if (row == 0 || col == 0)
            {
                MessageBox.Show("Kho chưa được thiết lập", "Chú ý", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            DataTable dt = controller.getLocationMatrix();
            int[] Id_ContentSimples = new int[dt.Rows.Count];
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
                    Id_ContentSimples[i] = Int32.Parse(dt.Rows[i]["Id_ContentSimple"].ToString());
                    Count_Containers[i] = Int32.Parse(dt.Rows[i]["Count_Container"].ToString());
                }
            }
            dgv_ware.RowTemplate.Height = 150;

            for (int i = 0; i <= col; i++)
            {
                DataGridViewColumn column = new DataGridViewTextBoxColumn();
                column.Name = "Column" + i.ToString();
                if (i == 0)
                {
                    column.Width = 50;
                    column.HeaderText = "STT";
                    column.ReadOnly = true;
                    dgv_ware.Columns.Add(column);
                    continue;
                }
                column.Width = 150;
                column.HeaderText = i.ToString();
                dgv_ware.Columns.Add(column);
            }

            for (int i = 0; i < row; i++)
            {
                dgv_ware.Rows.Add();
                dgv_ware.Rows[i].Cells[0].Value = i + 1;
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
                            /*DataGridViewImageCell imageCell = new DataGridViewImageCell();
                            string imgPath = Path.Combine("..", "..", "..", "Resources", "eye-solid.png"); // Thay đổi đường dẫn tới hình ảnh của bạn
                            imageCell.Value = Image.FromFile(imgPath);
                            dgv_ware["Column" + c.ToString(), r] = imageCell;
                            dgv_ware["Column" + c.ToString(), r].ReadOnly = false;
                            points[count] = new Point(c, r);
                            count++;*/
                            DataGridViewButtonCell buttonCell = new DataGridViewButtonCell();
                            buttonCell.Value = $"Thùng số {Id_ContentSimples[count]}\nSố lượng {Count_Containers[count]}";
                            dgv_ware["Column" + c.ToString(), r].ReadOnly = false;
                            points[count] = new Point(c, r);
                            count++;
                            dgv_ware["Column" + c.ToString(), r] = buttonCell;
                        }
                        else
                        {
                            dgv_ware["Column" + c.ToString(), r].Value = "Trống";
                            dgv_ware["Column" + c.ToString(), r].ReadOnly = true;
                        }
                    }
                    else
                    {
                        dgv_ware["Column" + c.ToString(), r].Value = "Trống";
                        dgv_ware["Column" + c.ToString(), r].ReadOnly = true;
                    }
                }
            }
        }
        private void btnProcess_Click(object sender, EventArgs e)
        {
            int rowWare = controller.getRowAndCol(out int colWare);
            if (rowWare == 0 || colWare == 0)
            {
                MessageBox.Show("Kho chưa được thiết lập", "Chú ý", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            List<decimal> Id_ContentSimples = new List<decimal>();
            bool checkBox = false;
            foreach (DataGridViewRow row in dgv406.Rows)
            {
                if (row != null)
                {
                    DataGridViewCheckBoxCell? chk = row.Cells["IsSelected"] as DataGridViewCheckBoxCell;
                    if (chk != null && chk.Value != null && (bool)chk.Value)
                    {
                        Id_ContentSimples.Add(Decimal.Parse(row.Cells["Id_ContentSimple"].Value.ToString()));
                        checkBox = true;
                    }
                }
            }

            if (checkBox)
            {
                if (MessageBox.Show("Bạn chắc chắn muốn lưu các thùng hàng trên vào kho ?", "Xác nhận hành động", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    if (controller.processClickStorage(Id_ContentSimples))
                    {
                        MessageBox.Show("Lưu kho thùng hàng thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
                        updateDGV();
                    }
                }
            }
            else
            {
                MessageBox.Show("Vui lòng chọn ít nhất 1 dòng", "Chú ý", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }
        }

        private void dgv406_ColumnAdded(object sender, DataGridViewColumnEventArgs e)
        {
            e.Column.SortMode = DataGridViewColumnSortMode.NotSortable;
        }

        private void dgv_ware_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            DataTable dt = controller.getLocationMatrix();
            if (e.RowIndex >= 0 && e.ColumnIndex >= 0 && dgv_ware[e.ColumnIndex, e.RowIndex] is DataGridViewButtonCell)
            {
                Point pos = new Point(e.ColumnIndex, e.RowIndex);
                int row = pos.Y + 1;
                int col = pos.X;
                foreach (DataRow r in dt.Rows)
                {
                    if (Int32.Parse(r["Rowi"].ToString()) == row && Int32.Parse(r["Colj"].ToString()) == col)
                    {
                        decimal Id_ContentSimple = Decimal.Parse(r["Id_ContentSimple"].ToString());
                        DataTable displayInfoOrder = controller.getInforOrderByIdContentSimple(Id_ContentSimple);
                        detailContentSimple dio = new detailContentSimple(displayInfoOrder, Id_ContentSimple);
                        dio.ShowDialog();
                        return;
                    }
                }
                return;

            }
        }

        private void dgv_ware_ColumnAdded(object sender, DataGridViewColumnEventArgs e)
        {
            e.Column.SortMode = DataGridViewColumnSortMode.NotSortable;
        }
    }
}
