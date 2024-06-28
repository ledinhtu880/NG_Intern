namespace NganGiang.Views
{
    partial class frm401
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frm401));
            lbHeader = new Label();
            btnProcess = new Button();
            panelDGV = new Panel();
            dgv401 = new DataGridView();
            timer1 = new System.Windows.Forms.Timer(components);
            panelDGV.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgv401).BeginInit();
            SuspendLayout();
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
            lbHeader.TabIndex = 15;
            lbHeader.Text = "Xử lý tại trạm 401";
            lbHeader.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // btnProcess
            // 
            btnProcess.Anchor = AnchorStyles.Bottom | AnchorStyles.Right;
            btnProcess.BackColor = Color.FromArgb(43, 76, 114);
            btnProcess.Font = new Font("Segoe UI", 14F, FontStyle.Bold);
            btnProcess.ForeColor = SystemColors.Control;
            btnProcess.Location = new Point(894, 466);
            btnProcess.Margin = new Padding(6);
            btnProcess.Name = "btnProcess";
            btnProcess.Size = new Size(433, 65);
            btnProcess.TabIndex = 18;
            btnProcess.Text = "Cấp thùng chứa và đế dán mã RFID";
            btnProcess.UseVisualStyleBackColor = false;
            btnProcess.Click += btnProcess_Click;
            // 
            // panelDGV
            // 
            panelDGV.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            panelDGV.Controls.Add(dgv401);
            panelDGV.Location = new Point(15, 75);
            panelDGV.Margin = new Padding(6);
            panelDGV.Name = "panelDGV";
            panelDGV.Size = new Size(1312, 379);
            panelDGV.TabIndex = 19;
            // 
            // dgv401
            // 
            dgv401.AllowDrop = true;
            dgv401.AllowUserToAddRows = false;
            dgv401.AllowUserToDeleteRows = false;
            dgv401.AllowUserToResizeColumns = false;
            dgv401.AllowUserToResizeRows = false;
            dgv401.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.DisplayedCells;
            dgv401.BackgroundColor = SystemColors.ControlLightLight;
            dgv401.ColumnHeadersBorderStyle = DataGridViewHeaderBorderStyle.Single;
            dataGridViewCellStyle1.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle1.BackColor = SystemColors.Control;
            dataGridViewCellStyle1.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle1.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle1.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle1.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle1.WrapMode = DataGridViewTriState.False;
            dgv401.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle1;
            dgv401.ColumnHeadersHeight = 60;
            dgv401.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            dataGridViewCellStyle2.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle2.BackColor = SystemColors.Window;
            dataGridViewCellStyle2.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle2.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle2.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle2.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle2.WrapMode = DataGridViewTriState.False;
            dgv401.DefaultCellStyle = dataGridViewCellStyle2;
            dgv401.Dock = DockStyle.Fill;
            dgv401.Location = new Point(0, 0);
            dgv401.Margin = new Padding(4);
            dgv401.MultiSelect = false;
            dgv401.Name = "dgv401";
            dataGridViewCellStyle3.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle3.BackColor = SystemColors.Control;
            dataGridViewCellStyle3.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle3.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle3.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle3.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle3.WrapMode = DataGridViewTriState.True;
            dgv401.RowHeadersDefaultCellStyle = dataGridViewCellStyle3;
            dgv401.RowHeadersVisible = false;
            dgv401.RowHeadersWidth = 51;
            dataGridViewCellStyle4.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle4.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dgv401.RowsDefaultCellStyle = dataGridViewCellStyle4;
            dgv401.ScrollBars = ScrollBars.Vertical;
            dgv401.SelectionMode = DataGridViewSelectionMode.FullRowSelect;
            dgv401.Size = new Size(1312, 379);
            dgv401.TabIndex = 2;
            dgv401.CellFormatting += dgv401_CellFormatting;
            // 
            // timer1
            // 
            timer1.Enabled = true;
            timer1.Interval = 1000;
            timer1.Tick += timer1_Tick;
            // 
            // frm401
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
            Name = "frm401";
            Text = "Trạm 401";
            WindowState = FormWindowState.Maximized;
            Load += frm401_Load;
            panelDGV.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgv401).EndInit();
            ResumeLayout(false);
        }

        #endregion

        private Label lbHeader;
        private Button btnProcess;
        private Panel panelDGV;
        private DataGridView dgv401;
        private System.Windows.Forms.Timer timer1;
    }
}