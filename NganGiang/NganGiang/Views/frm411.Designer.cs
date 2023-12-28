namespace NganGiang.Views
{
    partial class frm411
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frm411));
            panelDGV = new Panel();
            dgv411 = new DataGridView();
            IsSelected = new DataGridViewCheckBoxColumn();
            FK_Id_ContentPack = new DataGridViewTextBoxColumn();
            FK_Id_OrderLocal = new DataGridViewTextBoxColumn();
            Name_State = new DataGridViewTextBoxColumn();
            Date_Start = new DataGridViewTextBoxColumn();
            btnProcess = new Button();
            lbHeader = new Label();
            panelDGV.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgv411).BeginInit();
            SuspendLayout();
            // 
            // panelDGV
            // 
            panelDGV.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            panelDGV.Controls.Add(dgv411);
            panelDGV.Location = new Point(16, 78);
            panelDGV.Margin = new Padding(6);
            panelDGV.Name = "panelDGV";
            panelDGV.Size = new Size(1312, 379);
            panelDGV.TabIndex = 28;
            // 
            // dgv411
            // 
            dgv411.AllowUserToAddRows = false;
            dgv411.AllowUserToDeleteRows = false;
            dgv411.AllowUserToResizeColumns = false;
            dgv411.AllowUserToResizeRows = false;
            dgv411.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill;
            dgv411.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.AllCells;
            dgv411.BackgroundColor = Color.White;
            dataGridViewCellStyle1.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle1.BackColor = SystemColors.Control;
            dataGridViewCellStyle1.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle1.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle1.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle1.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle1.WrapMode = DataGridViewTriState.True;
            dgv411.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle1;
            dgv411.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            dgv411.Columns.AddRange(new DataGridViewColumn[] { IsSelected, FK_Id_ContentPack, FK_Id_OrderLocal, Name_State, Date_Start });
            dataGridViewCellStyle2.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle2.BackColor = SystemColors.Window;
            dataGridViewCellStyle2.Font = new Font("Segoe UI", 13.8F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle2.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle2.SelectionBackColor = Color.White;
            dataGridViewCellStyle2.SelectionForeColor = Color.Black;
            dataGridViewCellStyle2.WrapMode = DataGridViewTriState.False;
            dgv411.DefaultCellStyle = dataGridViewCellStyle2;
            dgv411.Dock = DockStyle.Fill;
            dgv411.GridColor = Color.Black;
            dgv411.Location = new Point(0, 0);
            dgv411.MultiSelect = false;
            dgv411.Name = "dgv411";
            dataGridViewCellStyle3.Alignment = DataGridViewContentAlignment.MiddleLeft;
            dataGridViewCellStyle3.BackColor = SystemColors.Control;
            dataGridViewCellStyle3.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle3.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle3.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle3.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle3.WrapMode = DataGridViewTriState.True;
            dgv411.RowHeadersDefaultCellStyle = dataGridViewCellStyle3;
            dgv411.RowHeadersWidth = 51;
            dgv411.SelectionMode = DataGridViewSelectionMode.CellSelect;
            dgv411.Size = new Size(1312, 379);
            dgv411.TabIndex = 8;
            dgv411.CellClick += dgv411_CellClick;
            dgv411.CellFormatting += dgv410_CellFormatting;
            dgv411.CellMouseEnter += dgv411_CellMouseEnter;
            dgv411.CellMouseLeave += dgv411_CellMouseLeave;
            // 
            // IsSelected
            // 
            IsSelected.DataPropertyName = "IsSelected";
            IsSelected.HeaderText = "Chọn";
            IsSelected.MinimumWidth = 6;
            IsSelected.Name = "IsSelected";
            IsSelected.Resizable = DataGridViewTriState.True;
            // 
            // FK_Id_ContentPack
            // 
            FK_Id_ContentPack.DataPropertyName = "FK_Id_ContentPack";
            FK_Id_ContentPack.HeaderText = "Mã gói hàng";
            FK_Id_ContentPack.MinimumWidth = 6;
            FK_Id_ContentPack.Name = "FK_Id_ContentPack";
            FK_Id_ContentPack.ReadOnly = true;
            FK_Id_ContentPack.SortMode = DataGridViewColumnSortMode.NotSortable;
            // 
            // FK_Id_OrderLocal
            // 
            FK_Id_OrderLocal.DataPropertyName = "FK_Id_OrderLocal";
            FK_Id_OrderLocal.HeaderText = "Mã đơn hàng";
            FK_Id_OrderLocal.MinimumWidth = 6;
            FK_Id_OrderLocal.Name = "FK_Id_OrderLocal";
            FK_Id_OrderLocal.ReadOnly = true;
            FK_Id_OrderLocal.SortMode = DataGridViewColumnSortMode.NotSortable;
            // 
            // Name_State
            // 
            Name_State.DataPropertyName = "Name_State";
            Name_State.HeaderText = "Trạng thái";
            Name_State.MinimumWidth = 6;
            Name_State.Name = "Name_State";
            Name_State.ReadOnly = true;
            Name_State.SortMode = DataGridViewColumnSortMode.NotSortable;
            // 
            // Date_Start
            // 
            Date_Start.DataPropertyName = "Date_Start";
            Date_Start.HeaderText = "Ngày bắt đầu";
            Date_Start.MinimumWidth = 6;
            Date_Start.Name = "Date_Start";
            Date_Start.ReadOnly = true;
            Date_Start.SortMode = DataGridViewColumnSortMode.NotSortable;
            // 
            // btnProcess
            // 
            btnProcess.Anchor = AnchorStyles.Bottom | AnchorStyles.Right;
            btnProcess.BackColor = Color.FromArgb(43, 76, 114);
            btnProcess.Font = new Font("Segoe UI", 14F, FontStyle.Bold);
            btnProcess.ForeColor = SystemColors.Control;
            btnProcess.Location = new Point(1068, 469);
            btnProcess.Margin = new Padding(6);
            btnProcess.Name = "btnProcess";
            btnProcess.Size = new Size(260, 65);
            btnProcess.TabIndex = 27;
            btnProcess.Text = "Quấn màng PE";
            btnProcess.UseVisualStyleBackColor = false;
            btnProcess.Click += btnProcess_Click;
            // 
            // lbHeader
            // 
            lbHeader.BackColor = Color.FromArgb(43, 76, 114);
            lbHeader.Font = new Font("Segoe UI", 14F, FontStyle.Bold);
            lbHeader.ForeColor = SystemColors.Control;
            lbHeader.Location = new Point(16, 12);
            lbHeader.Margin = new Padding(6, 0, 6, 0);
            lbHeader.Name = "lbHeader";
            lbHeader.Size = new Size(270, 56);
            lbHeader.TabIndex = 26;
            lbHeader.Text = "Xử lý tại trạm 411";
            lbHeader.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // frm411
            // 
            AcceptButton = btnProcess;
            AutoScaleDimensions = new SizeF(11F, 28F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(1345, 546);
            Controls.Add(panelDGV);
            Controls.Add(btnProcess);
            Controls.Add(lbHeader);
            Font = new Font("Segoe UI", 12F);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Margin = new Padding(4);
            Name = "frm411";
            StartPosition = FormStartPosition.CenterScreen;
            Text = "Trạm 411";
            WindowState = FormWindowState.Maximized;
            Load += frm411_Load;
            panelDGV.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgv411).EndInit();
            ResumeLayout(false);
        }

        #endregion

        private Panel panelDGV;
        private DataGridView dgv411;
        private DataGridViewCheckBoxColumn IsSelected;
        private DataGridViewTextBoxColumn FK_Id_ContentPack;
        private DataGridViewTextBoxColumn FK_Id_OrderLocal;
        private DataGridViewTextBoxColumn Name_State;
        private DataGridViewTextBoxColumn Date_Start;
        private Button btnProcess;
        private Label lbHeader;
    }
}