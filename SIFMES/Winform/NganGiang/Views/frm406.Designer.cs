namespace NganGiang.Views
{
    partial class frm406
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
            components = new System.ComponentModel.Container();
            DataGridViewCellStyle dataGridViewCellStyle1 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle2 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle3 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle4 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle5 = new DataGridViewCellStyle();
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frm406));
            panelDGV = new Panel();
            dgv406 = new DataGridView();
            IsSelected = new DataGridViewCheckBoxColumn();
            FK_Id_OrderLocal = new DataGridViewTextBoxColumn();
            SimpleOrPack = new DataGridViewTextBoxColumn();
            Id_ContentSimple = new DataGridViewTextBoxColumn();
            Name_RawMaterial = new DataGridViewTextBoxColumn();
            Count = new DataGridViewTextBoxColumn();
            Count_Need = new DataGridViewTextBoxColumn();
            Date_Start = new DataGridViewTextBoxColumn();
            Name_State = new DataGridViewTextBoxColumn();
            panelWarehouse = new Panel();
            groupBox1 = new GroupBox();
            dgv_ware = new DataGridView();
            btnProcess = new Button();
            lbHeader = new Label();
            timer1 = new System.Windows.Forms.Timer(components);
            panelDGV.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgv406).BeginInit();
            panelWarehouse.SuspendLayout();
            groupBox1.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgv_ware).BeginInit();
            SuspendLayout();
            // 
            // panelDGV
            // 
            panelDGV.Anchor = AnchorStyles.Top | AnchorStyles.Left | AnchorStyles.Right;
            panelDGV.Controls.Add(dgv406);
            panelDGV.Location = new Point(15, 78);
            panelDGV.Margin = new Padding(6);
            panelDGV.Name = "panelDGV";
            panelDGV.Size = new Size(1312, 379);
            panelDGV.TabIndex = 22;
            // 
            // dgv406
            // 
            dgv406.AllowUserToAddRows = false;
            dgv406.AllowUserToDeleteRows = false;
            dgv406.AllowUserToResizeColumns = false;
            dgv406.AllowUserToResizeRows = false;
            dgv406.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill;
            dgv406.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.DisplayedCells;
            dgv406.BackgroundColor = Color.White;
            dataGridViewCellStyle1.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle1.BackColor = SystemColors.Control;
            dataGridViewCellStyle1.Font = new Font("Segoe UI", 13.8F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle1.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle1.SelectionBackColor = SystemColors.MenuHighlight;
            dataGridViewCellStyle1.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle1.WrapMode = DataGridViewTriState.False;
            dgv406.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle1;
            dgv406.ColumnHeadersHeight = 60;
            dgv406.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            dgv406.Columns.AddRange(new DataGridViewColumn[] { IsSelected, FK_Id_OrderLocal, SimpleOrPack, Id_ContentSimple, Name_RawMaterial, Count, Count_Need, Date_Start, Name_State });
            dataGridViewCellStyle2.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle2.BackColor = SystemColors.Window;
            dataGridViewCellStyle2.Font = new Font("Segoe UI", 13.8F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle2.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle2.SelectionBackColor = Color.White;
            dataGridViewCellStyle2.SelectionForeColor = Color.Black;
            dataGridViewCellStyle2.WrapMode = DataGridViewTriState.False;
            dgv406.DefaultCellStyle = dataGridViewCellStyle2;
            dgv406.Dock = DockStyle.Fill;
            dgv406.Location = new Point(0, 0);
            dgv406.MultiSelect = false;
            dgv406.Name = "dgv406";
            dataGridViewCellStyle3.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle3.BackColor = SystemColors.Control;
            dataGridViewCellStyle3.Font = new Font("Segoe UI", 9F);
            dataGridViewCellStyle3.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle3.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle3.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle3.WrapMode = DataGridViewTriState.True;
            dgv406.RowHeadersDefaultCellStyle = dataGridViewCellStyle3;
            dgv406.RowHeadersVisible = false;
            dgv406.RowHeadersWidth = 51;
            dgv406.SelectionMode = DataGridViewSelectionMode.FullRowSelect;
            dgv406.Size = new Size(1312, 379);
            dgv406.TabIndex = 3;
            dgv406.ColumnAdded += dgv406_ColumnAdded;
            // 
            // IsSelected
            // 
            IsSelected.DataPropertyName = "IsSelected";
            IsSelected.FillWeight = 10F;
            IsSelected.HeaderText = "";
            IsSelected.MinimumWidth = 6;
            IsSelected.Name = "IsSelected";
            // 
            // FK_Id_OrderLocal
            // 
            FK_Id_OrderLocal.AutoSizeMode = DataGridViewAutoSizeColumnMode.Fill;
            FK_Id_OrderLocal.DataPropertyName = "FK_Id_OrderLocal";
            FK_Id_OrderLocal.FillWeight = 50F;
            FK_Id_OrderLocal.HeaderText = "Mã đơn hàng";
            FK_Id_OrderLocal.MinimumWidth = 6;
            FK_Id_OrderLocal.Name = "FK_Id_OrderLocal";
            FK_Id_OrderLocal.ReadOnly = true;
            // 
            // SimpleOrPack
            // 
            SimpleOrPack.AutoSizeMode = DataGridViewAutoSizeColumnMode.Fill;
            SimpleOrPack.DataPropertyName = "SimpleOrPack";
            SimpleOrPack.FillWeight = 50F;
            SimpleOrPack.HeaderText = "Loại hàng";
            SimpleOrPack.MinimumWidth = 6;
            SimpleOrPack.Name = "SimpleOrPack";
            SimpleOrPack.ReadOnly = true;
            // 
            // Id_ContentSimple
            // 
            Id_ContentSimple.AutoSizeMode = DataGridViewAutoSizeColumnMode.Fill;
            Id_ContentSimple.DataPropertyName = "Id_ContentSimple";
            Id_ContentSimple.FillWeight = 50F;
            Id_ContentSimple.HeaderText = "Mã thùng hàng";
            Id_ContentSimple.MinimumWidth = 6;
            Id_ContentSimple.Name = "Id_ContentSimple";
            Id_ContentSimple.ReadOnly = true;
            // 
            // Name_RawMaterial
            // 
            Name_RawMaterial.AutoSizeMode = DataGridViewAutoSizeColumnMode.Fill;
            Name_RawMaterial.DataPropertyName = "Name_RawMaterial";
            Name_RawMaterial.FillWeight = 74.8291245F;
            Name_RawMaterial.HeaderText = "Tên nguyên liệu thô";
            Name_RawMaterial.MinimumWidth = 6;
            Name_RawMaterial.Name = "Name_RawMaterial";
            Name_RawMaterial.ReadOnly = true;
            // 
            // Count
            // 
            Count.AutoSizeMode = DataGridViewAutoSizeColumnMode.Fill;
            Count.DataPropertyName = "Count";
            Count.FillWeight = 50F;
            Count.HeaderText = "Số lượng nguyên liệu tồn";
            Count.MinimumWidth = 6;
            Count.Name = "Count";
            Count.ReadOnly = true;
            // 
            // Count_Need
            // 
            Count_Need.AutoSizeMode = DataGridViewAutoSizeColumnMode.Fill;
            Count_Need.DataPropertyName = "Count_Need";
            Count_Need.FillWeight = 50F;
            Count_Need.HeaderText = "Số lượng nguyên liệu cần";
            Count_Need.MinimumWidth = 6;
            Count_Need.Name = "Count_Need";
            Count_Need.ReadOnly = true;
            // 
            // Date_Start
            // 
            Date_Start.AutoSizeMode = DataGridViewAutoSizeColumnMode.Fill;
            Date_Start.DataPropertyName = "Date_Start";
            Date_Start.FillWeight = 60F;
            Date_Start.HeaderText = "Ngày bắt đầu";
            Date_Start.MinimumWidth = 6;
            Date_Start.Name = "Date_Start";
            Date_Start.ReadOnly = true;
            // 
            // Name_State
            // 
            Name_State.AutoSizeMode = DataGridViewAutoSizeColumnMode.Fill;
            Name_State.DataPropertyName = "Name_State";
            Name_State.FillWeight = 50F;
            Name_State.HeaderText = "Trạng thái";
            Name_State.MinimumWidth = 6;
            Name_State.Name = "Name_State";
            Name_State.ReadOnly = true;
            // 
            // panelWarehouse
            // 
            panelWarehouse.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            panelWarehouse.Controls.Add(groupBox1);
            panelWarehouse.Location = new Point(15, 469);
            panelWarehouse.Name = "panelWarehouse";
            panelWarehouse.Size = new Size(1315, 310);
            panelWarehouse.TabIndex = 21;
            // 
            // groupBox1
            // 
            groupBox1.Controls.Add(dgv_ware);
            groupBox1.Dock = DockStyle.Fill;
            groupBox1.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            groupBox1.Location = new Point(0, 0);
            groupBox1.Name = "groupBox1";
            groupBox1.Size = new Size(1315, 310);
            groupBox1.TabIndex = 15;
            groupBox1.TabStop = false;
            groupBox1.Text = "Các thùng hàng trong kho (Click để xem chi tiết)";
            // 
            // dgv_ware
            // 
            dgv_ware.AllowUserToAddRows = false;
            dgv_ware.AllowUserToDeleteRows = false;
            dgv_ware.AllowUserToResizeColumns = false;
            dgv_ware.AllowUserToResizeRows = false;
            dgv_ware.BackgroundColor = Color.White;
            dataGridViewCellStyle4.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle4.BackColor = SystemColors.Control;
            dataGridViewCellStyle4.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle4.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle4.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle4.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle4.WrapMode = DataGridViewTriState.True;
            dgv_ware.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle4;
            dgv_ware.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            dataGridViewCellStyle5.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle5.BackColor = SystemColors.Window;
            dataGridViewCellStyle5.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle5.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle5.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle5.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle5.WrapMode = DataGridViewTriState.True;
            dgv_ware.DefaultCellStyle = dataGridViewCellStyle5;
            dgv_ware.Dock = DockStyle.Fill;
            dgv_ware.Location = new Point(3, 30);
            dgv_ware.MultiSelect = false;
            dgv_ware.Name = "dgv_ware";
            dgv_ware.RowHeadersVisible = false;
            dgv_ware.RowHeadersWidth = 51;
            dgv_ware.SelectionMode = DataGridViewSelectionMode.CellSelect;
            dgv_ware.Size = new Size(1309, 277);
            dgv_ware.TabIndex = 0;
            dgv_ware.CellContentClick += dgv_ware_CellContentClick;
            dgv_ware.ColumnAdded += dgv_ware_ColumnAdded;
            // 
            // btnProcess
            // 
            btnProcess.Anchor = AnchorStyles.Bottom | AnchorStyles.Right;
            btnProcess.BackColor = Color.FromArgb(43, 76, 114);
            btnProcess.Font = new Font("Segoe UI", 14F, FontStyle.Bold);
            btnProcess.ForeColor = SystemColors.Control;
            btnProcess.Location = new Point(1022, 788);
            btnProcess.Margin = new Padding(6);
            btnProcess.Name = "btnProcess";
            btnProcess.Size = new Size(308, 65);
            btnProcess.TabIndex = 23;
            btnProcess.Text = "Lưu thùng hàng vào kho";
            btnProcess.UseVisualStyleBackColor = false;
            btnProcess.Click += btnProcess_Click;
            // 
            // lbHeader
            // 
            lbHeader.BackColor = Color.FromArgb(43, 76, 114);
            lbHeader.Font = new Font("Segoe UI", 14F, FontStyle.Bold);
            lbHeader.ForeColor = SystemColors.Control;
            lbHeader.Location = new Point(15, 12);
            lbHeader.Margin = new Padding(6, 0, 6, 0);
            lbHeader.Name = "lbHeader";
            lbHeader.Size = new Size(270, 56);
            lbHeader.TabIndex = 24;
            lbHeader.Text = "Xử lý tại trạm 406";
            lbHeader.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // timer1
            // 
            timer1.Enabled = true;
            timer1.Interval = 1000;
            timer1.Tick += timer1_Tick;
            // 
            // frm406
            // 
            AcceptButton = btnProcess;
            AutoScaleDimensions = new SizeF(8F, 20F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(1345, 865);
            Controls.Add(panelDGV);
            Controls.Add(panelWarehouse);
            Controls.Add(btnProcess);
            Controls.Add(lbHeader);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Name = "frm406";
            Text = "Trạm 406";
            WindowState = FormWindowState.Maximized;
            Load += frm406_Load;
            panelDGV.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgv406).EndInit();
            panelWarehouse.ResumeLayout(false);
            groupBox1.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgv_ware).EndInit();
            ResumeLayout(false);
        }

        #endregion

        private Panel panelDGV;
        private Panel panelWarehouse;
        private GroupBox groupBox1;
        private Button btnProcess;
        private Label lbHeader;
        private DataGridView dgv406;
        private DataGridView dgv_ware;
        private DataGridViewCheckBoxColumn IsSelected;
        private DataGridViewTextBoxColumn FK_Id_OrderLocal;
        private DataGridViewTextBoxColumn SimpleOrPack;
        private DataGridViewTextBoxColumn Id_ContentSimple;
        private DataGridViewTextBoxColumn Name_RawMaterial;
        private DataGridViewTextBoxColumn Count;
        private DataGridViewTextBoxColumn Count_Need;
        private DataGridViewTextBoxColumn Date_Start;
        private DataGridViewTextBoxColumn Name_State;
        private System.Windows.Forms.Timer timer1;
    }
}