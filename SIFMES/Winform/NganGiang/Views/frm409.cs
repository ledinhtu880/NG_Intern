using FontAwesome.Sharp;
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
    public partial class frm409 : Form
    {
        Station409_Controller packController { get; set; }
        List<ContentPack> listContentPack = new List<ContentPack>();
        Point[] points;
        PLCService plcService { get; set; }
        bool isPLCReady = false;
        public frm409()
        {
            InitializeComponent();
            packController = new Station409_Controller();
            plcService = new PLCService();
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
            points = new Point[dt.Rows.Count];
            List<DetailStateCellOfPackWareHouse> matrixCurr = new List<DetailStateCellOfPackWareHouse>();

            if (dt.Rows.Count > 0)
            {
                for (int i = 0; i < dt.Rows.Count; i++)
                {
                    DetailStateCellOfPackWareHouse detail = new DetailStateCellOfPackWareHouse();
                    detail.Rowi = Int32.Parse(dt.Rows[i]["Rowi"].ToString());
                    detail.Colj = Int32.Parse(dt.Rows[i]["Colj"].ToString());
                    detail.FK_Id_ContentPack = Decimal.Parse(dt.Rows[i]["Id_ContentPack"].ToString());
                    detail.Count_Container = Int32.Parse(dt.Rows[i]["SoLuong"].ToString());
                    matrixCurr.Add(detail);
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
                    try
                    {
                        if (matrixCurr[count].Rowi == r + 1 && matrixCurr[count].Colj == c)
                        {
                            DataGridViewButtonCell buttonCell = new DataGridViewButtonCell();
                            buttonCell.Value = $"Gói hàng số {matrixCurr[count].FK_Id_ContentPack}\nSố lượng {matrixCurr[count].Count_Container}";
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
                    catch (Exception)
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
            if (!isPLCReady)
            {
                MessageBox.Show("PLC chưa sẵn sàng", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }
            foreach (DataGridViewRow rows in dgv409.Rows)
            {
                if (Convert.ToBoolean(rows.Cells[0].Value) == true)
                {
                    ContentPack item = new ContentPack();
                    item.Id_ContentPack = Convert.ToInt32(rows.Cells["Mã gói hàng"].Value.ToString());
                    item.Count_Pack = Convert.ToInt32(rows.Cells["Số lượng"].Value.ToString());

                    listContentPack.Add(item);
                }
            }
            if (listContentPack.Count > 0)
            {
                bool flag = false;
                if (MessageBox.Show("Bạn chắc chắn muốn lưu các gói hàng trên vào kho?", "Xác nhận hành động", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    foreach (var item in listContentPack)
                    {
                        int Id_ContentPack = Convert.ToInt32(item.Id_ContentPack);
                        plcService.sendTo409(item.Id_ContentPack, item.Count_Pack);
                        if (packController.UpdateStatePack(Id_ContentPack, 1, 409))
                        {
                            DataGridViewRow row = dgv409.Rows.Cast<DataGridViewRow>().FirstOrDefault(r => Convert.ToDecimal(r.Cells["Mã gói hàng"].Value) == item.Id_ContentPack);
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
                                packController.Update(Id_ContentPack);
                                break;
                            }
                        }
                        plcService.updateStatus();
                    }
                    loadData();
                }
            }
            else
            {
                MessageBox.Show("Bạn chưa chọn nội dung sản xuất!", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }
        private void dgv409_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex >= 0 && e.ColumnIndex == dgv409.Columns["XemChiTietColumn"].Index)
            {
                string id = dgv409.Rows[e.RowIndex].Cells["Mã gói hàng"].Value.ToString();

                detailContentPack detailForm = new detailContentPack();
                detailForm.SetContentPackID(id);
                detailForm.Show();
            }
        }
        private void dgv409_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
            if (dgv409.Columns[e.ColumnIndex].Name.Equals("XemChiTietColumn"))
            {
                string imagePath = Path.Combine(AppDomain.CurrentDomain.BaseDirectory, "Resources", "eye-solid.png");
                if (File.Exists(imagePath))
                {
                    Image image = Image.FromFile(imagePath);
                    e.Value = image;
                }
            }
        }
        private void dgvWare_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            DataTable dt = packController.getMatrix();
            if (e.RowIndex >= 0 && e.ColumnIndex >= 0 && dgvWare[e.ColumnIndex, e.RowIndex] is DataGridViewButtonCell)
            {
                Point pos = new Point(e.ColumnIndex, e.RowIndex);
                int row = pos.Y + 1;
                int col = pos.X;
                foreach (DataRow r in dt.Rows)
                {
                    if (Int32.Parse(r["Rowi"].ToString()) == row && Int32.Parse(r["Colj"].ToString()) == col)
                    {
                        string id = r["Id_ContentPack"].ToString();
                        detailContentPack detailForm = new detailContentPack();
                        detailForm.SetContentPackID(id);
                        detailForm.Show();
                        return;
                    }
                }
                return;
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
