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
using NganGiang.Services;
using NganGiang.Models;


namespace NganGiang.Views
{
    public partial class frm408 : Form
    {
        Station408_Controller processController { get; set; }
        List<ContentPack> listContentPack = new List<ContentPack>();
        PLCService plcService { get; set; }
        bool isPLCReady = false;
        public frm408()
        {
            InitializeComponent();
            processController = new Station408_Controller();
            plcService = new PLCService();
        }
        public void loadData()
        {
            processController.Show(dgv408);
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
                string imagePath = Path.Combine(AppDomain.CurrentDomain.BaseDirectory, "Resources", "eye-solid.png");
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
            listContentPack.Clear();
            if (!isPLCReady)
            {
                MessageBox.Show("PLC chưa sẵn sàng", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }
            foreach (DataGridViewRow rows in dgv408.Rows)
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
                if (MessageBox.Show("Bạn chắc chắn muốn đóng gói hàng?", "Xác nhận hành động", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    foreach (var item in listContentPack)
                    {
                        plcService.sendTo408(item.Id_ContentPack, item.Count_Pack);
                        if (processController.UpdateStatePack(Convert.ToInt32(item.Id_ContentPack), 1, 408))
                        {
                            DataGridViewRow row = dgv408.Rows.Cast<DataGridViewRow>().FirstOrDefault(r => Convert.ToDecimal(r.Cells["Mã gói hàng"].Value) == item.Id_ContentPack);
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
                                processController.Update(Convert.ToInt32(item.Id_ContentPack));
                                break;
                            }
                        }
                        plcService.updateStatus();
                    }
                    MessageBox.Show("Đóng gói thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    loadData();
                }
            }
            else
            {
                MessageBox.Show("Bạn chưa chọn nội dung sản xuất!", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Warning);
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
