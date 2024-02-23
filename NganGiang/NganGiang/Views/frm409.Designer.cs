namespace NganGiang.Views
{
    partial class frm409
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
            DataGridViewCellStyle dataGridViewCellStyle5 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle6 = new DataGridViewCellStyle();
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frm409));
            panelDGV = new Panel();
            dgv409 = new DataGridView();
            Column1 = new DataGridViewCheckBoxColumn();
            btnProcess = new Button();
            panelWarehouse = new Panel();
            groupBox1 = new GroupBox();
            dgvWare = new DataGridView();
            lbHeader = new Label();
            panelDGV.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgv409).BeginInit();
            panelWarehouse.SuspendLayout();
            groupBox1.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgvWare).BeginInit();
            SuspendLayout();
            // 
            // panelDGV
            // 
            panelDGV.Anchor = AnchorStyles.Top | AnchorStyles.Left | AnchorStyles.Right;
            panelDGV.Controls.Add(dgv409);
            panelDGV.Location = new Point(19, 94);
            panelDGV.Margin = new Padding(8, 8, 8, 8);
            panelDGV.Name = "panelDGV";
            panelDGV.Size = new Size(1640, 474);
            panelDGV.TabIndex = 13;
            // 
            // dgv409
            // 
            dgv409.AllowDrop = true;
            dgv409.AllowUserToAddRows = false;
            dgv409.AllowUserToDeleteRows = false;
            dgv409.AllowUserToResizeColumns = false;
            dgv409.AllowUserToResizeRows = false;
            dgv409.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill;
            dgv409.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.DisplayedCells;
            dgv409.BackgroundColor = SystemColors.ControlLightLight;
            dataGridViewCellStyle1.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle1.BackColor = SystemColors.Control;
            dataGridViewCellStyle1.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle1.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle1.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle1.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle1.WrapMode = DataGridViewTriState.False;
            dgv409.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle1;
            dgv409.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            dgv409.Columns.AddRange(new DataGridViewColumn[] { Column1 });
            dataGridViewCellStyle2.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle2.BackColor = SystemColors.Window;
            dataGridViewCellStyle2.Font = new Font("Segoe UI", 10F);
            dataGridViewCellStyle2.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle2.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle2.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle2.WrapMode = DataGridViewTriState.False;
            dgv409.DefaultCellStyle = dataGridViewCellStyle2;
            dgv409.Dock = DockStyle.Fill;
            dgv409.Location = new Point(0, 0);
            dgv409.Margin = new Padding(8, 8, 8, 8);
            dgv409.MultiSelect = false;
            dgv409.Name = "dgv409";
            dataGridViewCellStyle3.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle3.BackColor = SystemColors.Control;
            dataGridViewCellStyle3.Font = new Font("Segoe UI", 9F);
            dataGridViewCellStyle3.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle3.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle3.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle3.WrapMode = DataGridViewTriState.False;
            dgv409.RowHeadersDefaultCellStyle = dataGridViewCellStyle3;
            dgv409.RowHeadersWidthSizeMode = DataGridViewRowHeadersWidthSizeMode.AutoSizeToAllHeaders;
            dataGridViewCellStyle4.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dgv409.RowsDefaultCellStyle = dataGridViewCellStyle4;
            dgv409.SelectionMode = DataGridViewSelectionMode.FullRowSelect;
            dgv409.Size = new Size(1640, 474);
            dgv409.TabIndex = 4;
            dgv409.CellContentClick += dgv409_CellContentClick;
            dgv409.CellFormatting += dgv409_CellFormatting;
            // 
            // Column1
            // 
            Column1.AutoSizeMode = DataGridViewAutoSizeColumnMode.DisplayedCells;
            Column1.HeaderText = "";
            Column1.MinimumWidth = 6;
            Column1.Name = "Column1";
            Column1.Resizable = DataGridViewTriState.False;
            Column1.Width = 6;
            // 
            // btnProcess
            // 
            btnProcess.Anchor = AnchorStyles.Bottom | AnchorStyles.Right;
            btnProcess.BackColor = Color.FromArgb(43, 76, 114);
            btnProcess.Font = new Font("Segoe UI", 14F, FontStyle.Bold);
            btnProcess.ForeColor = SystemColors.Control;
            btnProcess.Location = new Point(1300, 950);
            btnProcess.Margin = new Padding(8, 8, 8, 8);
            btnProcess.Name = "btnProcess";
            btnProcess.Size = new Size(362, 81);
            btnProcess.TabIndex = 14;
            btnProcess.Text = "Lưu gói hàng vào kho";
            btnProcess.UseVisualStyleBackColor = false;
            btnProcess.Click += btnProcess_Click;
            // 
            // panelWarehouse
            // 
            panelWarehouse.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            panelWarehouse.Controls.Add(groupBox1);
            panelWarehouse.Location = new Point(19, 582);
            panelWarehouse.Margin = new Padding(4, 4, 4, 4);
            panelWarehouse.Name = "panelWarehouse";
            panelWarehouse.Size = new Size(1644, 388);
            panelWarehouse.TabIndex = 0;
            // 
            // groupBox1
            // 
            groupBox1.Controls.Add(dgvWare);
            groupBox1.Dock = DockStyle.Fill;
            groupBox1.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            groupBox1.Location = new Point(0, 0);
            groupBox1.Margin = new Padding(4, 4, 4, 4);
            groupBox1.Name = "groupBox1";
            groupBox1.Padding = new Padding(4, 4, 4, 4);
            groupBox1.Size = new Size(1644, 388);
            groupBox1.TabIndex = 15;
            groupBox1.TabStop = false;
            groupBox1.Text = "Các gói hàng trong kho (Click để xem chi tiết)";
            // 
            // dgvWare
            // 
            dgvWare.AllowUserToAddRows = false;
            dgvWare.AllowUserToDeleteRows = false;
            dgvWare.BackgroundColor = Color.White;
            dataGridViewCellStyle5.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle5.BackColor = SystemColors.Control;
            dataGridViewCellStyle5.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle5.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle5.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle5.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle5.WrapMode = DataGridViewTriState.True;
            dgvWare.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle5;
            dgvWare.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            dataGridViewCellStyle6.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle6.BackColor = SystemColors.Window;
            dataGridViewCellStyle6.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle6.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle6.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle6.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle6.WrapMode = DataGridViewTriState.True;
            dgvWare.DefaultCellStyle = dataGridViewCellStyle6;
            dgvWare.Dock = DockStyle.Fill;
            dgvWare.Location = new Point(4, 36);
            dgvWare.Margin = new Padding(4, 4, 4, 4);
            dgvWare.MultiSelect = false;
            dgvWare.Name = "dgvWare";
            dgvWare.RowHeadersVisible = false;
            dgvWare.RowHeadersWidth = 51;
            dgvWare.SelectionMode = DataGridViewSelectionMode.CellSelect;
            dgvWare.Size = new Size(1636, 348);
            dgvWare.TabIndex = 1;
            dgvWare.CellContentClick += dgvWare_CellContentClick;
            // 
            // lbHeader
            // 
            lbHeader.BackColor = Color.FromArgb(43, 76, 114);
            lbHeader.Font = new Font("Segoe UI", 14F, FontStyle.Bold);
            lbHeader.ForeColor = SystemColors.Control;
            lbHeader.Location = new Point(19, 11);
            lbHeader.Margin = new Padding(8, 0, 8, 0);
            lbHeader.Name = "lbHeader";
            lbHeader.Size = new Size(338, 70);
            lbHeader.TabIndex = 20;
            lbHeader.Text = "Xử lý tại trạm 409";
            lbHeader.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // frm409
            // 
            AcceptButton = btnProcess;
            AutoScaleDimensions = new SizeF(10F, 25F);
            AutoScaleMode = AutoScaleMode.Font;
            BackColor = SystemColors.Control;
            ClientSize = new Size(1681, 1050);
            Controls.Add(lbHeader);
            Controls.Add(panelWarehouse);
            Controls.Add(panelDGV);
            Controls.Add(btnProcess);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Margin = new Padding(4, 4, 4, 4);
            Name = "frm409";
            Text = "Trạm 409";
            WindowState = FormWindowState.Maximized;
            Load += frm409_Load;
            panelDGV.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgv409).EndInit();
            panelWarehouse.ResumeLayout(false);
            groupBox1.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgvWare).EndInit();
            ResumeLayout(false);
        }

        #endregion
        private Panel panelDGV;
        private Button btnProcess;
        private Panel panelWarehouse;
        private GroupBox groupBox1;
        private DataGridView dgv409;
        private DataGridViewCheckBoxColumn Column1;
        private Label lbHeader;
        private DataGridView dgvWare;
    }
}