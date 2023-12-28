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
        private IconButton button;
        private DataTable dtMatrix;
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
            updateTableLayoutPanel();
        }
        private void frm409_Load(object sender, EventArgs e)
        {
            loadData();
        }
        private void updateTableLayoutPanel()
        {
            tableWarehouse409.Controls.Clear();
            dtMatrix = packController.getMatrix();

            tableWarehouse409.RowStyles.Clear();
            tableWarehouse409.ColumnStyles.Clear();
            int row = packController.getRowAndCol(out int col);
            tableWarehouse409.RowCount = row;
            tableWarehouse409.ColumnCount = col;
            tableWarehouse409.Dock = DockStyle.Fill;

            for (int i = 0; i < tableWarehouse409.RowCount; i++)
            {
                tableWarehouse409.RowStyles.Add(new RowStyle(SizeType.Percent, 100f / tableWarehouse409.RowCount));
            }

            for (int i = 0; i < tableWarehouse409.ColumnCount; i++)
            {
                tableWarehouse409.ColumnStyles.Add(new ColumnStyle(SizeType.Percent, 100f / tableWarehouse409.ColumnCount));
            }

            for (int r = 0; r < row; r++)
            {
                for (int c = 0; c < col; c++)
                {
                    Panel panel = new Panel();
                    panel.Dock = DockStyle.Fill;
                    panel.Anchor = (AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right);


                    Label label = new Label();
                    label.Anchor = (AnchorStyles.Bottom | AnchorStyles.Right);
                    label.TextAlign = ContentAlignment.TopRight;
                    label.Text = (r + 1).ToString() + "." + (c + 1).ToString();
                    label.AutoSize = true;
                    label.Location = new Point(
                        (panel.Width - label.Width / 2), 0
                    );

                    button = new IconButton();
                    Label ept = new Label();
                    if (dtMatrix.Rows.Count > 0)
                    {
                        int copyR = r + 1;
                        int copyC = c + 1;
                        foreach (DataRow dtRow in dtMatrix.Rows)
                        {
                            int rowi = Int32.Parse(dtRow["Rowi"].ToString());
                            int colj = Int32.Parse(dtRow["Colj"].ToString());
                            if (rowi == copyR && colj == copyC)
                            {
                                panel.Controls.Clear();
                                Panel pn = new Panel();
                                pn.Anchor = AnchorStyles.Left | AnchorStyles.Right;
                                pn.Height = 40;
                                pn.Location = new Point(0, (panel.Height - pn.Height) / 2);

                                button.IconChar = IconChar.Eye;
                                button.IconColor = Color.FromArgb(52, 76, 114);
                                button.IconSize = 40;
                                button.FlatStyle = FlatStyle.Flat;
                                button.FlatAppearance.BorderSize = 0;
                                button.Anchor = AnchorStyles.None;
                                button.Size = new Size(40, 50);
                                button.Tag = dtRow["Id_ContentPack"].ToString(); // Lưu trữ giá trị vào thuộc tính Tag của button


                                Label nonept = new Label();
                                nonept.Text = "Gói hàng số " + dtRow["Id_ContentPack"].ToString();
                                nonept.TextAlign = ContentAlignment.MiddleCenter;
                                nonept.Width = 200;
                                nonept.Height = 50;
                                nonept.Anchor = AnchorStyles.None;
                                nonept.Font = new Font("Segoe UI", 13.8f);
                                nonept.Location = new Point(
                                    (pn.Width - nonept.Width - 10) / 2, 0
                                );

                                button.Location = new Point(
                                    (pn.Width - button.Width + nonept.Width) / 2, 5
                                );

                                pn.Controls.Add(nonept);
                                pn.Controls.Add(button);
                                button.BringToFront();
                                panel.Controls.Add(pn);
                                button.Click += IconButton_Click;
                            }
                            else
                            {
                                ept.Text = "Trống";
                                ept.Anchor = AnchorStyles.None;
                                ept.AutoSize = true;
                                ept.Font = new Font("Segoe UI", 13.8f);
                                ept.Location = new Point(
                                    (panel.Width - ept.Width) / 2,
                                    (panel.Height - ept.Height) / 2
                                );
                                panel.Controls.Add(ept);
                            }
                        }
                    }
                    else
                    {
                        ept.Text = "Trống";
                        ept.Anchor = AnchorStyles.None;
                        ept.AutoSize = true;
                        ept.Font = new Font("Segoe UI", 13.8f);
                        ept.Location = new Point(
                            (panel.Width - ept.Width) / 2,
                            (panel.Height - ept.Height) / 2
                        );
                        panel.Controls.Add(ept);
                    }

                    panel.Controls.Add(label);
                    tableWarehouse409.Controls.Add(panel, c, r);
                }
            }
        }

        private void IconButton_Click(object? sender, EventArgs e)
        {
            IconButton button = (IconButton)sender;
            string idContentPack = button.Tag.ToString(); // Truy cập giá trị đã lưu trữ trong Tag của button

            detailContentPack detailForm = new detailContentPack();
            detailForm.SetContentPackID(idContentPack);
            detailForm.Show();
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
