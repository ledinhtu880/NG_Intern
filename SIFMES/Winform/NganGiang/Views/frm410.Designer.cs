namespace NganGiang.Views
{
    partial class frm410
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frm410));
            panelDGV = new Panel();
            dgv410 = new DataGridView();
            isSelected = new DataGridViewCheckBoxColumn();
            btnProcess = new Button();
            lbHeader = new Label();
            panelDGV.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgv410).BeginInit();
            SuspendLayout();
            // 
            // panelDGV
            // 
            panelDGV.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            panelDGV.Controls.Add(dgv410);
            panelDGV.Location = new Point(16, 78);
            panelDGV.Margin = new Padding(6);
            panelDGV.Name = "panelDGV";
            panelDGV.Size = new Size(1312, 379);
            panelDGV.TabIndex = 25;
            // 
            // dgv410
            // 
            dgv410.AllowUserToAddRows = false;
            dgv410.AllowUserToDeleteRows = false;
            dgv410.AllowUserToResizeColumns = false;
            dgv410.AllowUserToResizeRows = false;
            dgv410.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill;
            dgv410.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.DisplayedCells;
            dgv410.BackgroundColor = Color.White;
            dataGridViewCellStyle1.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle1.BackColor = SystemColors.Control;
            dataGridViewCellStyle1.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle1.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle1.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle1.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle1.WrapMode = DataGridViewTriState.True;
            dgv410.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle1;
            dgv410.ColumnHeadersHeight = 60;
            dgv410.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            dgv410.Columns.AddRange(new DataGridViewColumn[] { isSelected });
            dataGridViewCellStyle2.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle2.BackColor = SystemColors.Window;
            dataGridViewCellStyle2.Font = new Font("Segoe UI", 13.8F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle2.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle2.SelectionBackColor = Color.White;
            dataGridViewCellStyle2.SelectionForeColor = Color.Black;
            dataGridViewCellStyle2.WrapMode = DataGridViewTriState.False;
            dgv410.DefaultCellStyle = dataGridViewCellStyle2;
            dgv410.Dock = DockStyle.Fill;
            dgv410.GridColor = Color.Black;
            dgv410.Location = new Point(0, 0);
            dgv410.MultiSelect = false;
            dgv410.Name = "dgv410";
            dataGridViewCellStyle3.Alignment = DataGridViewContentAlignment.MiddleLeft;
            dataGridViewCellStyle3.BackColor = SystemColors.Control;
            dataGridViewCellStyle3.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle3.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle3.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle3.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle3.WrapMode = DataGridViewTriState.True;
            dgv410.RowHeadersDefaultCellStyle = dataGridViewCellStyle3;
            dgv410.RowHeadersVisible = false;
            dgv410.RowHeadersWidth = 51;
            dgv410.SelectionMode = DataGridViewSelectionMode.CellSelect;
            dgv410.Size = new Size(1312, 379);
            dgv410.TabIndex = 8;
            dgv410.CellClick += dgv410_CellClick;
            dgv410.CellFormatting += dgv410_CellFormatting;
            dgv410.CellMouseEnter += dgv410_CellMouseEnter;
            dgv410.CellMouseLeave += dgv410_CellMouseLeave;
            // 
            // isSelected
            // 
            isSelected.FillWeight = 10F;
            isSelected.HeaderText = "";
            isSelected.MinimumWidth = 6;
            isSelected.Name = "isSelected";
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
            btnProcess.TabIndex = 24;
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
            lbHeader.TabIndex = 23;
            lbHeader.Text = "Xử lý tại trạm 410";
            lbHeader.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // frm410
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
            Name = "frm410";
            Text = "Trạm 410";
            WindowState = FormWindowState.Maximized;
            Load += frm410_Load;
            panelDGV.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgv410).EndInit();
            ResumeLayout(false);
        }

        #endregion

        private Panel panelDGV;
        private Button btnProcess;
        private Label lbHeader;
        private DataGridView dgv410;
        private DataGridViewCheckBoxColumn isSelected;
    }
}