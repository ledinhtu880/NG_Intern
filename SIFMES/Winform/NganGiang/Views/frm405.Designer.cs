namespace NganGiang.Views
{
    partial class frm405
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frm405));
            panelDGV = new Panel();
            dgv405 = new DataGridView();
            btnProcess = new Button();
            lbHeader = new Label();
            panelDGV.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgv405).BeginInit();
            SuspendLayout();
            // 
            // panelDGV
            // 
            panelDGV.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            panelDGV.Controls.Add(dgv405);
            panelDGV.Location = new Point(16, 78);
            panelDGV.Margin = new Padding(6);
            panelDGV.Name = "panelDGV";
            panelDGV.Size = new Size(1312, 379);
            panelDGV.TabIndex = 22;
            // 
            // dgv405
            // 
            dgv405.AllowDrop = true;
            dgv405.AllowUserToAddRows = false;
            dgv405.AllowUserToDeleteRows = false;
            dgv405.AllowUserToResizeColumns = false;
            dgv405.AllowUserToResizeRows = false;
            dgv405.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill;
            dgv405.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.DisplayedCells;
            dgv405.BackgroundColor = SystemColors.ControlLightLight;
            dgv405.ColumnHeadersBorderStyle = DataGridViewHeaderBorderStyle.Single;
            dataGridViewCellStyle1.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle1.BackColor = SystemColors.Control;
            dataGridViewCellStyle1.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle1.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle1.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle1.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle1.WrapMode = DataGridViewTriState.False;
            dgv405.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle1;
            dgv405.ColumnHeadersHeight = 60;
            dgv405.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            dataGridViewCellStyle2.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle2.BackColor = SystemColors.Window;
            dataGridViewCellStyle2.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle2.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle2.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle2.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle2.WrapMode = DataGridViewTriState.False;
            dgv405.DefaultCellStyle = dataGridViewCellStyle2;
            dgv405.Dock = DockStyle.Fill;
            dgv405.Location = new Point(0, 0);
            dgv405.Margin = new Padding(4);
            dgv405.MultiSelect = false;
            dgv405.Name = "dgv405";
            dataGridViewCellStyle3.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle3.BackColor = SystemColors.Control;
            dataGridViewCellStyle3.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle3.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle3.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle3.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle3.WrapMode = DataGridViewTriState.True;
            dgv405.RowHeadersDefaultCellStyle = dataGridViewCellStyle3;
            dgv405.RowHeadersVisible = false;
            dgv405.RowHeadersWidth = 51;
            dataGridViewCellStyle4.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle4.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dgv405.RowsDefaultCellStyle = dataGridViewCellStyle4;
            dgv405.ScrollBars = ScrollBars.Vertical;
            dgv405.SelectionMode = DataGridViewSelectionMode.FullRowSelect;
            dgv405.Size = new Size(1312, 379);
            dgv405.TabIndex = 2;
            dgv405.CellFormatting += dgv405_CellFormatting;
            dgv405.ColumnAdded += dgv405_ColumnAdded;
            // 
            // btnProcess
            // 
            btnProcess.Anchor = AnchorStyles.Bottom | AnchorStyles.Right;
            btnProcess.BackColor = Color.FromArgb(43, 76, 114);
            btnProcess.Font = new Font("Segoe UI", 14F, FontStyle.Bold);
            btnProcess.ForeColor = SystemColors.Control;
            btnProcess.Location = new Point(1044, 469);
            btnProcess.Margin = new Padding(6);
            btnProcess.Name = "btnProcess";
            btnProcess.Size = new Size(284, 65);
            btnProcess.TabIndex = 21;
            btnProcess.Text = "Cấp nắp thùng chứa";
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
            lbHeader.TabIndex = 20;
            lbHeader.Text = "Xử lý tại trạm 405";
            lbHeader.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // frm405
            // 
            AcceptButton = btnProcess;
            AutoScaleDimensions = new SizeF(8F, 20F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(1345, 546);
            Controls.Add(panelDGV);
            Controls.Add(btnProcess);
            Controls.Add(lbHeader);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Name = "frm405";
            Text = "Trạm 405";
            WindowState = FormWindowState.Maximized;
            Load += frm405_Load;
            panelDGV.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgv405).EndInit();
            ResumeLayout(false);
        }

        #endregion

        private Panel panelDGV;
        private DataGridView dgv405;
        private Button btnProcess;
        private Label lbHeader;
    }
}