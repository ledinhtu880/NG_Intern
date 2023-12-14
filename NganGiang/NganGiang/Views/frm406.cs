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
        private IconButton button;
        private DataTable dtMatrix;
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
            updateTableLayoutPanel();
        }

        private void updateTableLayoutPanel()
        {
            tableWarehouse406.Controls.Clear();
            dtMatrix = controller.getLocationMatrix();

            tableWarehouse406.RowStyles.Clear();
            tableWarehouse406.ColumnStyles.Clear();
            int row = controller.getRowAndCol(out int col);
            tableWarehouse406.RowCount = row;
            tableWarehouse406.ColumnCount = col;
            tableWarehouse406.Dock = DockStyle.Fill;

            for (int i = 0; i < tableWarehouse406.RowCount; i++)
            {
                tableWarehouse406.RowStyles.Add(new RowStyle(SizeType.Percent, 100f / tableWarehouse406.RowCount));
            }

            for (int i = 0; i < tableWarehouse406.ColumnCount; i++)
            {
                tableWarehouse406.ColumnStyles.Add(new ColumnStyle(SizeType.Percent, 100f / tableWarehouse406.ColumnCount));
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
                                pn.Height = 50;
                                pn.Location = new Point(0, (panel.Height - pn.Height) / 2);

                                button.IconChar = IconChar.Eye;
                                button.IconColor = Color.FromArgb(52, 76, 114);
                                button.IconSize = 40;
                                button.FlatStyle = FlatStyle.Flat;
                                button.FlatAppearance.BorderSize = 0;
                                button.Anchor = AnchorStyles.None;
                                button.Size = new Size(40, 50);
                                button.Tag = new Point(colj, rowi);


                                Label nonept = new Label();
                                nonept.Text = "Thùng hàng số " + dtRow["Id_SimpleContent"].ToString();
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
                    tableWarehouse406.Controls.Add(panel, c, r);
                }
            }
        }
        private void IconButton_Click(object sender, EventArgs e)
        {
            IconButton button = (IconButton)sender;
            Point pos = (Point)button.Tag;
            int col = pos.X;
            int row = pos.Y;


            foreach (DataRow r in dtMatrix.Rows)
            {
                if (Int32.Parse(r["Rowi"].ToString()) == row && Int32.Parse(r["Colj"].ToString()) == col)
                {
                    decimal Id_SimpleContent = Decimal.Parse(r["Id_SimpleContent"].ToString());
                    DataTable displayInfoOrder = controller.getInforOrderByIdSimpleContent(Id_SimpleContent);
                    detailContentSimple dio = new detailContentSimple(displayInfoOrder, Id_SimpleContent);
                    dio.ShowDialog();
                    return;
                }
            }
        }
        private void btnProcess_Click(object sender, EventArgs e)
        {
            List<decimal> Id_ContentSimples = new List<decimal>();
            bool checkBox = false;
            foreach (DataGridViewRow row in dgv406.Rows)
            {
                if (row != null)
                {
                    DataGridViewCheckBoxCell? chk = row.Cells["IsSelected"] as DataGridViewCheckBoxCell;
                    if (chk != null && chk.Value != null && (bool)chk.Value)
                    {
                        Id_ContentSimples.Add(Decimal.Parse(row.Cells["Id_SimpleContent"].Value.ToString()));
                        checkBox = true;
                    }
                }
            }

            if (checkBox)
            {
                if (MessageBox.Show("Bạn chắc chắn muốn lưu các thùng hàng trên vào kho ?", "Xác nhận hành động", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    controller.processClickStorage(Id_ContentSimples);
                    MessageBox.Show("Lưu kho thùng hàng thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    updateDGV();
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
    }
}
