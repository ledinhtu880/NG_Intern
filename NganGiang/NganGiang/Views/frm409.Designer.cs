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
            DataGridViewCellStyle dataGridViewCellStyle7 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle8 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle9 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle10 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle11 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle12 = new DataGridViewCellStyle();
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frm409));
            panelDGV = new Panel();
            dgv409 = new DataGridView();
            Column1 = new DataGridViewCheckBoxColumn();
            btnProcess = new Button();
            panelWarehouse = new Panel();
            groupBox1 = new GroupBox();
            lbHeader = new Label();
            dgvWare = new DataGridView();
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
            panelDGV.Location = new Point(15, 75);
            panelDGV.Margin = new Padding(6);
            panelDGV.Name = "panelDGV";
            panelDGV.Size = new Size(1312, 379);
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
            dataGridViewCellStyle7.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle7.BackColor = SystemColors.Control;
            dataGridViewCellStyle7.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle7.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle7.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle7.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle7.WrapMode = DataGridViewTriState.False;
            dgv409.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle7;
            dgv409.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            dgv409.Columns.AddRange(new DataGridViewColumn[] { Column1 });
            dataGridViewCellStyle8.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle8.BackColor = SystemColors.Window;
            dataGridViewCellStyle8.Font = new Font("Segoe UI", 10F);
            dataGridViewCellStyle8.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle8.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle8.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle8.WrapMode = DataGridViewTriState.False;
            dgv409.DefaultCellStyle = dataGridViewCellStyle8;
            dgv409.Dock = DockStyle.Fill;
            dgv409.Location = new Point(0, 0);
            dgv409.Margin = new Padding(6);
            dgv409.MultiSelect = false;
            dgv409.Name = "dgv409";
            dataGridViewCellStyle9.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle9.BackColor = SystemColors.Control;
            dataGridViewCellStyle9.Font = new Font("Segoe UI", 9F);
            dataGridViewCellStyle9.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle9.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle9.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle9.WrapMode = DataGridViewTriState.False;
            dgv409.RowHeadersDefaultCellStyle = dataGridViewCellStyle9;
            dgv409.RowHeadersWidthSizeMode = DataGridViewRowHeadersWidthSizeMode.AutoSizeToAllHeaders;
            dataGridViewCellStyle10.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dgv409.RowsDefaultCellStyle = dataGridViewCellStyle10;
            dgv409.SelectionMode = DataGridViewSelectionMode.FullRowSelect;
            dgv409.Size = new Size(1312, 379);
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
            btnProcess.Location = new Point(1040, 785);
            btnProcess.Margin = new Padding(6);
            btnProcess.Name = "btnProcess";
            btnProcess.Size = new Size(290, 65);
            btnProcess.TabIndex = 14;
            btnProcess.Text = "Lưu gói hàng vào kho";
            btnProcess.UseVisualStyleBackColor = false;
            btnProcess.Click += btnProcess_Click;
            // 
            // panelWarehouse
            // 
            panelWarehouse.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            panelWarehouse.Controls.Add(groupBox1);
            panelWarehouse.Location = new Point(15, 466);
            panelWarehouse.Name = "panelWarehouse";
            panelWarehouse.Size = new Size(1315, 310);
            panelWarehouse.TabIndex = 0;
            // 
            // groupBox1
            // 
            groupBox1.Controls.Add(dgvWare);
            groupBox1.Dock = DockStyle.Fill;
            groupBox1.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            groupBox1.Location = new Point(0, 0);
            groupBox1.Name = "groupBox1";
            groupBox1.Size = new Size(1315, 310);
            groupBox1.TabIndex = 15;
            groupBox1.TabStop = false;
            groupBox1.Text = "Các gói hàng trong kho (Click để xem chi tiết)";
            // 
            // lbHeader
            // 
            lbHeader.BackColor = Color.FromArgb(43, 76, 114);
            lbHeader.Font = new Font("Segoe UI", 14F, FontStyle.Bold);
            lbHeader.ForeColor = SystemColors.Control;
            lbHeader.Location = new Point(15, 9);
            lbHeader.Margin = new Padding(6, 0, 6, 0);
            lbHeader.Name = "lbHeader";
            lbHeader.Size = new Size(270, 56);
            lbHeader.TabIndex = 20;
            lbHeader.Text = "Xử lý tại trạm 409";
            lbHeader.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // dgvWare
            // 
            dgvWare.AllowUserToAddRows = false;
            dgvWare.AllowUserToDeleteRows = false;
            dgvWare.BackgroundColor = Color.White;
            dataGridViewCellStyle11.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle11.BackColor = SystemColors.Control;
            dataGridViewCellStyle11.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle11.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle11.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle11.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle11.WrapMode = DataGridViewTriState.True;
            dgvWare.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle11;
            dgvWare.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            dataGridViewCellStyle12.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle12.BackColor = SystemColors.Window;
            dataGridViewCellStyle12.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle12.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle12.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle12.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle12.WrapMode = DataGridViewTriState.True;
            dgvWare.DefaultCellStyle = dataGridViewCellStyle12;
            dgvWare.Dock = DockStyle.Fill;
            dgvWare.Location = new Point(3, 30);
            dgvWare.MultiSelect = false;
            dgvWare.Name = "dgvWare";
            dgvWare.RowHeadersVisible = false;
            dgvWare.RowHeadersWidth = 51;
            dgvWare.SelectionMode = DataGridViewSelectionMode.CellSelect;
            dgvWare.Size = new Size(1309, 277);
            dgvWare.TabIndex = 1;
            // 
            // frm409
            // 
            AcceptButton = btnProcess;
            AutoScaleDimensions = new SizeF(8F, 20F);
            AutoScaleMode = AutoScaleMode.Font;
            BackColor = SystemColors.Control;
            ClientSize = new Size(1345, 865);
            Controls.Add(lbHeader);
            Controls.Add(panelWarehouse);
            Controls.Add(panelDGV);
            Controls.Add(btnProcess);
            Icon = (Icon)resources.GetObject("$this.Icon");
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