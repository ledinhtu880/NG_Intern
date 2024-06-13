namespace NganGiang.Views
{
    partial class frm403
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frm403));
            lbHeader = new Label();
            panelDGV = new Panel();
            dgv403 = new DataGridView();
            Column1 = new DataGridViewCheckBoxColumn();
            btnProcess = new Button();
            timer1 = new System.Windows.Forms.Timer(components);
            panelDGV.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgv403).BeginInit();
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
            lbHeader.TabIndex = 0;
            lbHeader.Text = "Xử lý tại trạm 403";
            lbHeader.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // panelDGV
            // 
            panelDGV.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            panelDGV.Controls.Add(dgv403);
            panelDGV.Location = new Point(15, 75);
            panelDGV.Margin = new Padding(6);
            panelDGV.Name = "panelDGV";
            panelDGV.Size = new Size(1312, 379);
            panelDGV.TabIndex = 7;
            // 
            // dgv403
            // 
            dgv403.AllowDrop = true;
            dgv403.AllowUserToAddRows = false;
            dgv403.AllowUserToDeleteRows = false;
            dgv403.AllowUserToResizeColumns = false;
            dgv403.AllowUserToResizeRows = false;
            dgv403.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill;
            dgv403.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.DisplayedCells;
            dgv403.BackgroundColor = SystemColors.ControlLightLight;
            dgv403.ColumnHeadersBorderStyle = DataGridViewHeaderBorderStyle.Single;
            dataGridViewCellStyle5.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle5.BackColor = SystemColors.Control;
            dataGridViewCellStyle5.Font = new Font("Segoe UI", 12F, FontStyle.Bold);
            dataGridViewCellStyle5.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle5.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle5.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle5.WrapMode = DataGridViewTriState.False;
            dgv403.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle5;
            dgv403.ColumnHeadersHeight = 60;
            dgv403.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            dgv403.Columns.AddRange(new DataGridViewColumn[] { Column1 });
            dataGridViewCellStyle6.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle6.BackColor = SystemColors.Window;
            dataGridViewCellStyle6.Font = new Font("Segoe UI", 10F);
            dataGridViewCellStyle6.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle6.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle6.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle6.WrapMode = DataGridViewTriState.False;
            dgv403.DefaultCellStyle = dataGridViewCellStyle6;
            dgv403.Dock = DockStyle.Fill;
            dgv403.Location = new Point(0, 0);
            dgv403.Margin = new Padding(6);
            dgv403.MultiSelect = false;
            dgv403.Name = "dgv403";
            dataGridViewCellStyle7.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle7.BackColor = SystemColors.Control;
            dataGridViewCellStyle7.Font = new Font("Segoe UI", 9F);
            dataGridViewCellStyle7.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle7.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle7.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle7.WrapMode = DataGridViewTriState.False;
            dgv403.RowHeadersDefaultCellStyle = dataGridViewCellStyle7;
            dgv403.RowHeadersVisible = false;
            dgv403.RowHeadersWidth = 51;
            dataGridViewCellStyle8.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dgv403.RowsDefaultCellStyle = dataGridViewCellStyle8;
            dgv403.SelectionMode = DataGridViewSelectionMode.FullRowSelect;
            dgv403.Size = new Size(1312, 379);
            dgv403.TabIndex = 2;
            dgv403.CellFormatting += dgv403_CellFormatting;
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
            btnProcess.Location = new Point(1060, 466);
            btnProcess.Margin = new Padding(6);
            btnProcess.Name = "btnProcess";
            btnProcess.Size = new Size(267, 65);
            btnProcess.TabIndex = 8;
            btnProcess.Text = "Rót nguyên liệu lỏng";
            btnProcess.UseVisualStyleBackColor = false;
            btnProcess.Click += btnProcess_Click;
            // 
            // timer1
            // 
            timer1.Enabled = true;
            timer1.Tick += timer1_Tick;
            // 
            // frm403
            // 
            AcceptButton = btnProcess;
            AutoScaleDimensions = new SizeF(11F, 28F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(1345, 546);
            Controls.Add(lbHeader);
            Controls.Add(panelDGV);
            Controls.Add(btnProcess);
            Font = new Font("Segoe UI", 12F);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Margin = new Padding(4);
            Name = "frm403";
            StartPosition = FormStartPosition.CenterScreen;
            Text = "Trạm 403";
            WindowState = FormWindowState.Maximized;
            Load += frm403_Load;
            panelDGV.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgv403).EndInit();
            ResumeLayout(false);
        }

        #endregion
        private Label lbHeader;
        private Panel panelDGV;
        private DataGridView dgv403;
        private DataGridViewCheckBoxColumn Column1;
        private Button btnProcess;
        private System.Windows.Forms.Timer timer1;
    }
}