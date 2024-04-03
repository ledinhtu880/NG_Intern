using NganGiang.Controllers;
using NganGiang.Libs;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace NganGiang.Views
{
  public partial class frmPermission : Form
  {
    PermissionController permissionController { get; set; }
    List<int> listStation = new List<int>();
    public frmPermission()
    {
      InitializeComponent();
      permissionController = new PermissionController();
    }
    private void frmPermission_Load(object sender, EventArgs e)
    {
      permissionController.DisplayName(cbName);
    }
    private void cbName_SelectedValueChanged(object sender, EventArgs e)
    {
      if (cbName.SelectedValue != null)
      {
        if (cbName.SelectedValue is DataRowView)
        {
          int userId = Convert.ToInt32(((DataRowView)cbName.SelectedValue)["Id_User"]);
          permissionController.ShowData(dgvPermission, userId);
        }
        else
        {
          permissionController.ShowData(dgvPermission, Convert.ToInt32(cbName.SelectedValue.ToString()));
        }
      }
      else
      {
        MessageBox.Show("Giá trị không khả dụng");
      }
    }
    private void btnProcess_Click(object sender, EventArgs e)
    {
      listStation.Clear();
      foreach (DataGridViewRow rows in dgvPermission.Rows)
      {
        if (Convert.ToBoolean(rows.Cells["Phân quyền"].Value) == true)
        {
          listStation.Add(Convert.ToInt32(rows.Cells["Trạm"].Value.ToString()));
        }
      }

      if (MessageBox.Show("Bạn chắc chắn muốn phân quyền cho người dùng này?", "Xác nhận hành động", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
      {
        int Id_User = Convert.ToInt32(cbName.SelectedValue);
        permissionController.DeleteData(Id_User);
        foreach (var item in listStation)
        {
          permissionController.AddData(Id_User, item);
        }
        MessageBox.Show("Phân quyền thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
      }
    }
  }
}
