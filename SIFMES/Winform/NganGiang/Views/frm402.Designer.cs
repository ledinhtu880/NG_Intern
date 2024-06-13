namespace NganGiang.Views
{
    partial class frm402
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frm402));
            panelDGV = new Panel();
            dgv402 = new DataGridView();
            IsSelected = new DataGridViewCheckBoxColumn();
            btnProcess = new Button();
            lbHeader = new Label();
            timer1 = new System.Windows.Forms.Timer(components);
            panelDGV.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgv402).BeginInit();
            SuspendLayout();
            // 
            // panelDGV
            // 
            panelDGV.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            panelDGV.Controls.Add(dgv402);
            panelDGV.Location = new Point(16, 78);
            panelDGV.Margin = new Padding(6);
            panelDGV.Name = "panelDGV";
            panelDGV.Size = new Size(1312, 379);
            panelDGV.TabIndex = 22;
            // 
            // dgv402
            // 
            dgv402.AllowDrop = true;
            dgv402.AllowUserToAddRows = false;
            dgv402.AllowUserToDeleteRows = false;
            dgv402.AllowUserToResizeColumns = false;
            dgv402.AllowUserToResizeRows = false;
            dgv402.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill;
            dgv402.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.DisplayedCells;
            dgv402.BackgroundColor = SystemColors.ControlLightLight;
            dgv402.ColumnHeadersBorderStyle = DataGridViewHeaderBorderStyle.Single;
            dataGridViewCellStyle5.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle5.BackColor = SystemColors.Control;
            dataGridViewCellStyle5.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle5.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle5.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle5.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle5.WrapMode = DataGridViewTriState.False;
            dgv402.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle5;
            dgv402.ColumnHeadersHeight = 60;
            dgv402.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            dgv402.Columns.AddRange(new DataGridViewColumn[] { IsSelected });
            dataGridViewCellStyle6.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle6.BackColor = SystemColors.Window;
            dataGridViewCellStyle6.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle6.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle6.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle6.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle6.WrapMode = DataGridViewTriState.False;
            dgv402.DefaultCellStyle = dataGridViewCellStyle6;
            dgv402.Dock = DockStyle.Fill;
            dgv402.Location = new Point(0, 0);
            dgv402.Margin = new Padding(4);
            dgv402.MultiSelect = false;
            dgv402.Name = "dgv402";
            dataGridViewCellStyle7.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle7.BackColor = SystemColors.Control;
            dataGridViewCellStyle7.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle7.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle7.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle7.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle7.WrapMode = DataGridViewTriState.True;
            dgv402.RowHeadersDefaultCellStyle = dataGridViewCellStyle7;
            dgv402.RowHeadersVisible = false;
            dgv402.RowHeadersWidth = 51;
            dataGridViewCellStyle8.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle8.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dgv402.RowsDefaultCellStyle = dataGridViewCellStyle8;
            dgv402.ScrollBars = ScrollBars.Vertical;
            dgv402.SelectionMode = DataGridViewSelectionMode.FullRowSelect;
            dgv402.Size = new Size(1312, 379);
            dgv402.TabIndex = 3;
            dgv402.CellFormatting += dgv402_CellFormatting;
            // 
            // IsSelected
            // 
            IsSelected.FillWeight = 20F;
            IsSelected.HeaderText = "";
            IsSelected.MinimumWidth = 6;
            IsSelected.Name = "IsSelected";
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
            btnProcess.TabIndex = 21;
            btnProcess.Text = "Rót nguyên liệu rắn";
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
            lbHeader.TabIndex = 20;
            lbHeader.Text = "Xử lý tại trạm 402";
            lbHeader.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // timer1
            // 
            timer1.Enabled = true;
            timer1.Interval = 1000;
            timer1.Tick += timer1_Tick;
            // 
            // frm402
            // 
            AcceptButton = btnProcess;
            AutoScaleDimensions = new SizeF(8F, 20F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(1345, 546);
            Controls.Add(panelDGV);
            Controls.Add(btnProcess);
            Controls.Add(lbHeader);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Name = "frm402";
            Text = "Trạm 402";
            WindowState = FormWindowState.Maximized;
            Load += frm402_Load;
            panelDGV.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgv402).EndInit();
            ResumeLayout(false);
        }

        #endregion

        private Panel panelDGV;
        private Button btnProcess;
        private Label lbHeader;
        private DataGridView dgv402;
        private System.Windows.Forms.Timer timer1;
        private DataGridViewCheckBoxColumn IsSelected;
    }
}