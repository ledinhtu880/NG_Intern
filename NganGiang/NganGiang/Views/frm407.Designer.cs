namespace NganGiang.Views
{
    partial class frm407
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frm407));
            panelDGV = new Panel();
            dgv407 = new DataGridView();
            btnProcess = new Button();
            lbHeader = new Label();
            panelDGV.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgv407).BeginInit();
            SuspendLayout();
            // 
            // panelDGV
            // 
            panelDGV.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            panelDGV.Controls.Add(dgv407);
            panelDGV.Location = new Point(17, 80);
            panelDGV.Margin = new Padding(6);
            panelDGV.Name = "panelDGV";
            panelDGV.Size = new Size(1312, 379);
            panelDGV.TabIndex = 25;
            // 
            // dgv407
            // 
            dgv407.AllowDrop = true;
            dgv407.AllowUserToAddRows = false;
            dgv407.AllowUserToDeleteRows = false;
            dgv407.AllowUserToResizeColumns = false;
            dgv407.AllowUserToResizeRows = false;
            dgv407.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill;
            dgv407.BackgroundColor = SystemColors.ControlLightLight;
            dgv407.ColumnHeadersBorderStyle = DataGridViewHeaderBorderStyle.Single;
            dataGridViewCellStyle1.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle1.BackColor = SystemColors.Control;
            dataGridViewCellStyle1.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle1.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle1.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle1.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle1.WrapMode = DataGridViewTriState.False;
            dgv407.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle1;
            dgv407.ColumnHeadersHeight = 29;
            dataGridViewCellStyle2.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle2.BackColor = SystemColors.Window;
            dataGridViewCellStyle2.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle2.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle2.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle2.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle2.WrapMode = DataGridViewTriState.False;
            dgv407.DefaultCellStyle = dataGridViewCellStyle2;
            dgv407.Dock = DockStyle.Fill;
            dgv407.Location = new Point(0, 0);
            dgv407.Margin = new Padding(4);
            dgv407.MultiSelect = false;
            dgv407.Name = "dgv407";
            dataGridViewCellStyle3.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle3.BackColor = SystemColors.Control;
            dataGridViewCellStyle3.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle3.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle3.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle3.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle3.WrapMode = DataGridViewTriState.True;
            dgv407.RowHeadersDefaultCellStyle = dataGridViewCellStyle3;
            dgv407.RowHeadersWidth = 51;
            dataGridViewCellStyle4.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle4.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dgv407.RowsDefaultCellStyle = dataGridViewCellStyle4;
            dgv407.ScrollBars = ScrollBars.Vertical;
            dgv407.SelectionMode = DataGridViewSelectionMode.FullRowSelect;
            dgv407.Size = new Size(1312, 379);
            dgv407.TabIndex = 2;
            dgv407.CellFormatting += dgv407_CellFormatting;
            dgv407.ColumnAdded += dgv407_ColumnAdded;
            // 
            // btnProcess
            // 
            btnProcess.Anchor = AnchorStyles.Bottom | AnchorStyles.Right;
            btnProcess.BackColor = Color.FromArgb(43, 76, 114);
            btnProcess.Font = new Font("Segoe UI", 14F, FontStyle.Bold);
            btnProcess.ForeColor = SystemColors.Control;
            btnProcess.Location = new Point(867, 471);
            btnProcess.Margin = new Padding(6);
            btnProcess.Name = "btnProcess";
            btnProcess.Size = new Size(462, 65);
            btnProcess.TabIndex = 24;
            btnProcess.Text = "Dán nhãn và xuất phiếu giao (nếu có)";
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
            lbHeader.TabIndex = 23;
            lbHeader.Text = "Xử lý tại trạm 407";
            lbHeader.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // frm407
            // 
            AcceptButton = btnProcess;
            AutoScaleDimensions = new SizeF(8F, 20F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(1345, 546);
            Controls.Add(panelDGV);
            Controls.Add(btnProcess);
            Controls.Add(lbHeader);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Name = "frm407";
            Text = "Trạm 407";
            WindowState = FormWindowState.Maximized;
            Load += Process407_Load;
            panelDGV.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgv407).EndInit();
            ResumeLayout(false);
        }

        #endregion

        private Panel panelDGV;
        private DataGridView dgv407;
        private Button btnProcess;
        private Label lbHeader;
    }
}