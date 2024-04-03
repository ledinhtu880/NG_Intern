namespace NganGiang.Views
{
    partial class frmPermission
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frmPermission));
            btnProcess = new Button();
            lbHeader = new Label();
            panelDGV = new Panel();
            dgvPermission = new DataGridView();
            label1 = new Label();
            cbName = new ComboBox();
            panelDGV.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgvPermission).BeginInit();
            SuspendLayout();
            // 
            // btnProcess
            // 
            btnProcess.Anchor = AnchorStyles.Bottom | AnchorStyles.Right;
            btnProcess.BackColor = Color.FromArgb(43, 76, 114);
            btnProcess.Font = new Font("Segoe UI", 14F, FontStyle.Bold);
            btnProcess.ForeColor = SystemColors.Control;
            btnProcess.Location = new Point(405, 564);
            btnProcess.Margin = new Padding(6);
            btnProcess.Name = "btnProcess";
            btnProcess.Size = new Size(109, 45);
            btnProcess.TabIndex = 20;
            btnProcess.Text = "Lưu";
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
            lbHeader.TabIndex = 19;
            lbHeader.Text = "Phân quyền trạm";
            lbHeader.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // panelDGV
            // 
            panelDGV.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            panelDGV.Controls.Add(dgvPermission);
            panelDGV.Location = new Point(15, 117);
            panelDGV.Margin = new Padding(6);
            panelDGV.Name = "panelDGV";
            panelDGV.Size = new Size(499, 435);
            panelDGV.TabIndex = 21;
            // 
            // dgvPermission
            // 
            dgvPermission.AllowDrop = true;
            dgvPermission.AllowUserToAddRows = false;
            dgvPermission.AllowUserToDeleteRows = false;
            dgvPermission.AllowUserToResizeColumns = false;
            dgvPermission.AllowUserToResizeRows = false;
            dgvPermission.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill;
            dgvPermission.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.DisplayedCells;
            dgvPermission.BackgroundColor = SystemColors.ControlLightLight;
            dgvPermission.ColumnHeadersBorderStyle = DataGridViewHeaderBorderStyle.Single;
            dataGridViewCellStyle1.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle1.BackColor = SystemColors.Control;
            dataGridViewCellStyle1.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle1.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle1.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle1.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle1.WrapMode = DataGridViewTriState.False;
            dgvPermission.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle1;
            dgvPermission.ColumnHeadersHeight = 60;
            dgvPermission.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            dataGridViewCellStyle2.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle2.BackColor = SystemColors.Window;
            dataGridViewCellStyle2.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle2.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle2.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle2.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle2.WrapMode = DataGridViewTriState.False;
            dgvPermission.DefaultCellStyle = dataGridViewCellStyle2;
            dgvPermission.Dock = DockStyle.Fill;
            dgvPermission.Location = new Point(0, 0);
            dgvPermission.Margin = new Padding(4);
            dgvPermission.MultiSelect = false;
            dgvPermission.Name = "dgvPermission";
            dataGridViewCellStyle3.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle3.BackColor = SystemColors.Control;
            dataGridViewCellStyle3.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle3.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle3.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle3.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle3.WrapMode = DataGridViewTriState.True;
            dgvPermission.RowHeadersDefaultCellStyle = dataGridViewCellStyle3;
            dgvPermission.RowHeadersVisible = false;
            dgvPermission.RowHeadersWidth = 51;
            dataGridViewCellStyle4.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle4.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dgvPermission.RowsDefaultCellStyle = dataGridViewCellStyle4;
            dgvPermission.ScrollBars = ScrollBars.Vertical;
            dgvPermission.SelectionMode = DataGridViewSelectionMode.FullRowSelect;
            dgvPermission.Size = new Size(499, 435);
            dgvPermission.TabIndex = 2;
            // 
            // label1
            // 
            label1.AutoSize = true;
            label1.Location = new Point(18, 75);
            label1.Name = "label1";
            label1.Size = new Size(149, 28);
            label1.TabIndex = 22;
            label1.Text = "Tên người dùng";
            // 
            // cbName
            // 
            cbName.DropDownStyle = ComboBoxStyle.DropDownList;
            cbName.FormattingEnabled = true;
            cbName.Location = new Point(173, 73);
            cbName.Name = "cbName";
            cbName.Size = new Size(200, 36);
            cbName.TabIndex = 23;
            cbName.SelectedValueChanged += cbName_SelectedValueChanged;
            // 
            // frmPermission
            // 
            AutoScaleDimensions = new SizeF(11F, 28F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(529, 615);
            Controls.Add(cbName);
            Controls.Add(label1);
            Controls.Add(panelDGV);
            Controls.Add(btnProcess);
            Controls.Add(lbHeader);
            Font = new Font("Segoe UI", 12F);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Margin = new Padding(4);
            Name = "frmPermission";
            StartPosition = FormStartPosition.CenterScreen;
            Text = "Phân quyền trạm";
            Load += frmPermission_Load;
            panelDGV.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgvPermission).EndInit();
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

        private Button btnProcess;
        private Label lbHeader;
        private Panel panelDGV;
        private DataGridView dgvPermission;
        private Label label1;
        private ComboBox cbName;
    }
}