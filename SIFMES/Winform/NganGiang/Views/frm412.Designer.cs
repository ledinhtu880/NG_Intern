namespace NganGiang.Views
{
    partial class frm412
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frm412));
            panelDGV = new Panel();
            dgv412 = new DataGridView();
            IsSelected = new DataGridViewCheckBoxColumn();
            FK_Id_ContentPack = new DataGridViewTextBoxColumn();
            FK_Id_OrderLocal = new DataGridViewTextBoxColumn();
            Name_State = new DataGridViewTextBoxColumn();
            Date_Start = new DataGridViewTextBoxColumn();
            btnProcess = new Button();
            lbHeader = new Label();
            panelDGV.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgv412).BeginInit();
            SuspendLayout();
            // 
            // panelDGV
            // 
            panelDGV.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            panelDGV.Controls.Add(dgv412);
            panelDGV.Location = new Point(15, 75);
            panelDGV.Margin = new Padding(6);
            panelDGV.Name = "panelDGV";
            panelDGV.Size = new Size(1312, 379);
            panelDGV.TabIndex = 37;
            // 
            // dgv412
            // 
            dgv412.AllowUserToAddRows = false;
            dgv412.AllowUserToDeleteRows = false;
            dgv412.AllowUserToResizeColumns = false;
            dgv412.AllowUserToResizeRows = false;
            dgv412.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill;
            dgv412.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.DisplayedCells;
            dgv412.BackgroundColor = Color.White;
            dataGridViewCellStyle1.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle1.BackColor = SystemColors.Control;
            dataGridViewCellStyle1.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle1.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle1.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle1.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle1.WrapMode = DataGridViewTriState.True;
            dgv412.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle1;
            dgv412.ColumnHeadersHeight = 60;
            dgv412.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            dgv412.Columns.AddRange(new DataGridViewColumn[] { IsSelected, FK_Id_ContentPack, FK_Id_OrderLocal, Name_State, Date_Start });
            dataGridViewCellStyle2.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle2.BackColor = SystemColors.Window;
            dataGridViewCellStyle2.Font = new Font("Segoe UI", 12F);
            dataGridViewCellStyle2.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle2.SelectionBackColor = Color.White;
            dataGridViewCellStyle2.SelectionForeColor = Color.Black;
            dataGridViewCellStyle2.WrapMode = DataGridViewTriState.False;
            dgv412.DefaultCellStyle = dataGridViewCellStyle2;
            dgv412.Dock = DockStyle.Fill;
            dgv412.GridColor = Color.Black;
            dgv412.Location = new Point(0, 0);
            dgv412.MultiSelect = false;
            dgv412.Name = "dgv412";
            dgv412.RowHeadersVisible = false;
            dgv412.RowHeadersWidth = 51;
            dgv412.SelectionMode = DataGridViewSelectionMode.CellSelect;
            dgv412.Size = new Size(1312, 379);
            dgv412.TabIndex = 8;
            dgv412.CellClick += dgv412_CellClick;
            dgv412.CellFormatting += dgv412_CellFormatting;
            dgv412.CellMouseEnter += dgv412_CellMouseEnter;
            dgv412.CellMouseLeave += dgv412_CellMouseLeave;
            // 
            // IsSelected
            // 
            IsSelected.DataPropertyName = "IsSelected";
            IsSelected.FillWeight = 10F;
            IsSelected.HeaderText = "";
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
            btnProcess.Location = new Point(1019, 466);
            btnProcess.Margin = new Padding(6);
            btnProcess.Name = "btnProcess";
            btnProcess.Size = new Size(308, 65);
            btnProcess.TabIndex = 36;
            btnProcess.Text = "Xuất phiếu giao hàng";
            btnProcess.UseVisualStyleBackColor = false;
            btnProcess.Click += btnProcess_Click;
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
            lbHeader.TabIndex = 35;
            lbHeader.Text = "Xử lý tại trạm 412";
            lbHeader.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // frm412
            // 
            AutoScaleDimensions = new SizeF(11F, 28F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(1327, 549);
            Controls.Add(panelDGV);
            Controls.Add(btnProcess);
            Controls.Add(lbHeader);
            Font = new Font("Segoe UI", 12F);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Margin = new Padding(4);
            Name = "frm412";
            StartPosition = FormStartPosition.CenterScreen;
            Text = "Trạm 412";
            WindowState = FormWindowState.Maximized;
            Load += frm412_Load;
            panelDGV.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgv412).EndInit();
            ResumeLayout(false);
        }

        #endregion

        private Panel panelDGV;
        private DataGridView dgv412;
        private Button btnProcess;
        private Label lbHeader;
        private DataGridViewCheckBoxColumn IsSelected;
        private DataGridViewTextBoxColumn FK_Id_ContentPack;
        private DataGridViewTextBoxColumn FK_Id_OrderLocal;
        private DataGridViewTextBoxColumn Name_State;
        private DataGridViewTextBoxColumn Date_Start;
    }
}