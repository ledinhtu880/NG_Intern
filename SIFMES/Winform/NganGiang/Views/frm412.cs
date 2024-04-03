using NganGiang.Controllers;
using System.Data;

namespace NganGiang.Views
{
    public partial class frm412 : Form
    {
        public frm412()
        {
            InitializeComponent();
            process412Controller = new Station412_Controller();
        }
        Station412_Controller process412Controller { get; set; }

        private void LoadData()
        {
            DataTable dt = process412Controller.DisplayListOrderProcess();
            dgv412.DataSource = dt;
        }

        private void frm412_Load(object sender, EventArgs e)
        {
            LoadData();

            foreach (DataGridViewColumn column in dgv412.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }

            DataGridViewImageColumn imageColumn = new DataGridViewImageColumn();
            imageColumn.Name = "btnShowInfor";
            imageColumn.HeaderText = "Xem chi tiết";
            dgv412.Columns.Add(imageColumn);
        }

        List<int> list_id_pack = new List<int>();
        private void btnProcess_Click(object sender, EventArgs e)
        {
            list_id_pack.Clear();
            foreach (DataGridViewRow row in dgv412.Rows)
            {
                if (Convert.ToBoolean(row.Cells[0].Value) == true)
                {
                    list_id_pack.Add(Convert.ToInt32(row.Cells["FK_Id_ContentPack"].Value));

                }
            }

            if (list_id_pack.Count > 0)
            {
                DialogResult confirm = MessageBox.Show("Bạn chắc chắn xuất phiếu giao hàng cho các gói đã chọn?", "Xác nhận hành động", MessageBoxButtons.OKCancel, MessageBoxIcon.Question);
                if (confirm == DialogResult.OK)
                {
                    foreach (var item in list_id_pack)
                    {
                        process412Controller.UpdateData(item);
                    }
                    MessageBox.Show("Xuất phiếu giao thành công!", "", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    LoadData();
                }
            }
            else
            {
                MessageBox.Show("Bạn chưa chọn nội dung gói!", "Chú ý", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }

        private void dgv412_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
            if (dgv412.Columns[e.ColumnIndex].Name.Equals("btnShowInfor"))
            {
                string imagePath = Path.Combine(AppDomain.CurrentDomain.BaseDirectory, "Resources", "eye-solid.png");
                if (File.Exists(imagePath))
                {
                    Image image = Image.FromFile(imagePath);
                    e.Value = image;
                }
            }
        }

        private void dgv412_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.ColumnIndex == dgv412.Columns["btnShowInfor"].Index && e.RowIndex >= 0)
            {
                string id = dgv412.Rows[e.RowIndex].Cells["FK_Id_ContentPack"].Value.ToString();

                detailContentPack detailForm = new detailContentPack();
                detailForm.SetContentPackID(id);
                detailForm.Show();
            }
        }

        private void dgv412_CellMouseEnter(object sender, DataGridViewCellEventArgs e)
        {
            if (e.ColumnIndex == dgv412.Columns["btnShowInfor"].Index && e.RowIndex >= 0)
            {
                DataGridViewCell cell = dgv412.Rows[e.RowIndex].Cells[e.ColumnIndex];
                if (cell != null)
                {
                    cell.Style.BackColor = Color.FromArgb(132, 145, 165);
                }
            }
        }

        private void dgv412_CellMouseLeave(object sender, DataGridViewCellEventArgs e)
        {
            if (e.ColumnIndex == dgv412.Columns["btnShowInfor"].Index && e.RowIndex >= 0)
            {
                DataGridViewCell cell = dgv412.Rows[e.RowIndex].Cells[e.ColumnIndex];
                if (cell != null)
                {
                    cell.Style.BackColor = Color.White;
                }
            }
        }


    }
}
