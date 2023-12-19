namespace NganGiang.Views
{
    partial class detailContentPack
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            DataGridViewCellStyle dataGridViewCellStyle1 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle2 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle3 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle4 = new DataGridViewCellStyle();
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(detailContentPack));
            panelDGV = new Panel();
            dgvDetailContentPack = new DataGridView();
            lbHeader = new Label();
            btnBack = new Button();
            panelDGV.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgvDetailContentPack).BeginInit();
            SuspendLayout();
            // 
            // panelDGV
            // 
            panelDGV.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            panelDGV.Controls.Add(dgvDetailContentPack);
            panelDGV.Location = new Point(16, 78);
            panelDGV.Margin = new Padding(6);
            panelDGV.Name = "panelDGV";
            panelDGV.Size = new Size(1463, 468);
            panelDGV.TabIndex = 25;
            // 
            // dgvDetailContentPack
            // 
            dgvDetailContentPack.AllowDrop = true;
            dgvDetailContentPack.AllowUserToAddRows = false;
            dgvDetailContentPack.AllowUserToDeleteRows = false;
            dgvDetailContentPack.AllowUserToResizeColumns = false;
            dgvDetailContentPack.AllowUserToResizeRows = false;
            dgvDetailContentPack.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill;
            dgvDetailContentPack.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.DisplayedCells;
            dgvDetailContentPack.BackgroundColor = SystemColors.ControlLightLight;
            dgvDetailContentPack.ColumnHeadersBorderStyle = DataGridViewHeaderBorderStyle.Single;
            dataGridViewCellStyle1.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle1.BackColor = SystemColors.Control;
            dataGridViewCellStyle1.Font = new Font("Segoe UI", 12F, FontStyle.Bold);
            dataGridViewCellStyle1.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle1.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle1.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle1.WrapMode = DataGridViewTriState.False;
            dgvDetailContentPack.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle1;
            dgvDetailContentPack.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            dataGridViewCellStyle2.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle2.BackColor = SystemColors.Window;
            dataGridViewCellStyle2.Font = new Font("Segoe UI", 10F);
            dataGridViewCellStyle2.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle2.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle2.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle2.WrapMode = DataGridViewTriState.False;
            dgvDetailContentPack.DefaultCellStyle = dataGridViewCellStyle2;
            dgvDetailContentPack.Dock = DockStyle.Fill;
            dgvDetailContentPack.Location = new Point(0, 0);
            dgvDetailContentPack.Margin = new Padding(6);
            dgvDetailContentPack.MultiSelect = false;
            dgvDetailContentPack.Name = "dgvDetailContentPack";
            dataGridViewCellStyle3.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle3.BackColor = SystemColors.Control;
            dataGridViewCellStyle3.Font = new Font("Segoe UI", 9F);
            dataGridViewCellStyle3.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle3.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle3.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle3.WrapMode = DataGridViewTriState.False;
            dgvDetailContentPack.RowHeadersDefaultCellStyle = dataGridViewCellStyle3;
            dgvDetailContentPack.RowHeadersWidth = 51;
            dataGridViewCellStyle4.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dgvDetailContentPack.RowsDefaultCellStyle = dataGridViewCellStyle4;
            dgvDetailContentPack.SelectionMode = DataGridViewSelectionMode.FullRowSelect;
            dgvDetailContentPack.Size = new Size(1463, 468);
            dgvDetailContentPack.TabIndex = 2;
            // 
            // lbHeader
            // 
            lbHeader.BackColor = Color.FromArgb(43, 76, 114);
            lbHeader.Font = new Font("Segoe UI", 14F, FontStyle.Bold);
            lbHeader.ForeColor = SystemColors.Control;
            lbHeader.Location = new Point(15, 9);
            lbHeader.Margin = new Padding(6, 0, 6, 0);
            lbHeader.Name = "lbHeader";
            lbHeader.Size = new Size(423, 56);
            lbHeader.TabIndex = 24;
            lbHeader.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // btnBack
            // 
            btnBack.Anchor = AnchorStyles.Bottom | AnchorStyles.Right;
            btnBack.BackColor = Color.FromArgb(43, 76, 114);
            btnBack.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            btnBack.ForeColor = SystemColors.Control;
            btnBack.Location = new Point(1236, 558);
            btnBack.Margin = new Padding(6);
            btnBack.Name = "btnBack";
            btnBack.Size = new Size(243, 65);
            btnBack.TabIndex = 23;
            btnBack.Text = "Quay lại";
            btnBack.UseVisualStyleBackColor = false;
            btnBack.Click += btnBack_Click;
            // 
            // detailContentPack
            // 
            AutoScaleDimensions = new SizeF(8F, 20F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(1496, 635);
            Controls.Add(panelDGV);
            Controls.Add(lbHeader);
            Controls.Add(btnBack);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Name = "detailContentPack";
            StartPosition = FormStartPosition.CenterScreen;
            Text = "Xem chi tiết gói hàng";
            Load += detailContentPack408_Load;
            panelDGV.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgvDetailContentPack).EndInit();
            ResumeLayout(false);
        }

        #endregion

        private Panel panelDGV;
        private DataGridView dgvDetailContentPack;
        private Label lbHeader;
        private Button btnBack;
    }
}