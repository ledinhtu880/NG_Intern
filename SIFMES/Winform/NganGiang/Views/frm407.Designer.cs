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
            components = new System.ComponentModel.Container();
            DataGridViewCellStyle dataGridViewCellStyle5 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle6 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle7 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle8 = new DataGridViewCellStyle();
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frm407));
            panelDGV = new Panel();
            dgv407 = new DataGridView();
            btnProcess = new Button();
            lbHeader = new Label();
            timer1 = new System.Windows.Forms.Timer(components);
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
            dgv407.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.DisplayedCells;
            dgv407.BackgroundColor = SystemColors.ControlLightLight;
            dgv407.ColumnHeadersBorderStyle = DataGridViewHeaderBorderStyle.Single;
            dataGridViewCellStyle5.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle5.BackColor = SystemColors.Control;
            dataGridViewCellStyle5.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle5.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle5.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle5.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle5.WrapMode = DataGridViewTriState.False;
            dgv407.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle5;
            dgv407.ColumnHeadersHeight = 60;
            dgv407.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            dataGridViewCellStyle6.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle6.BackColor = SystemColors.Window;
            dataGridViewCellStyle6.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle6.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle6.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle6.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle6.WrapMode = DataGridViewTriState.False;
            dgv407.DefaultCellStyle = dataGridViewCellStyle6;
            dgv407.Dock = DockStyle.Fill;
            dgv407.Location = new Point(0, 0);
            dgv407.Margin = new Padding(4);
            dgv407.MultiSelect = false;
            dgv407.Name = "dgv407";
            dataGridViewCellStyle7.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle7.BackColor = SystemColors.Control;
            dataGridViewCellStyle7.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle7.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle7.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle7.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle7.WrapMode = DataGridViewTriState.True;
            dgv407.RowHeadersDefaultCellStyle = dataGridViewCellStyle7;
            dgv407.RowHeadersVisible = false;
            dgv407.RowHeadersWidth = 51;
            dataGridViewCellStyle8.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle8.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dgv407.RowsDefaultCellStyle = dataGridViewCellStyle8;
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
            // timer1
            // 
            timer1.Enabled = true;
            timer1.Interval = 1000;
            timer1.Tick += timer1_Tick;
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
        private System.Windows.Forms.Timer timer1;
    }
}