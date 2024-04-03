using NganGiang.Services.Process;
using Org.BouncyCastle.Bcpg.OpenPgp;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Security.Policy;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Controllers
{
  internal class PermissionController
  {
    PermissionService permissionService { get; set; }
    public PermissionController()
    {
      permissionService = new PermissionService();
    }
    public void DisplayName(ComboBox cbBox)
    {
      cbBox.DataSource = permissionService.DisplayName();
      cbBox.DisplayMember = "Name";
      cbBox.ValueMember = "Id_User";
    }
    public void ShowData(DataGridView dgv, int id)
    {
      dgv.DataSource = permissionService.ShowData(id);
    }
    public void DeleteData(int id)
    {
      permissionService.DeleteData(id);
    }
    public void AddData(int id, int item)
    {
      permissionService.AddData(id, item);
    }
  }
}
