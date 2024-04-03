using System;
using System.Collections.Generic;
using System.Data;
using System.Data.SqlClient;
using System.Linq;
using System.Reflection.Metadata.Ecma335;
using System.Text;
using System.Threading.Tasks;
using NganGiang.Libs;

namespace NganGiang.Services.Process
{
  internal class PermissionService
  {
    public DataTable DisplayName()
    {
      string query = "select Id_User, Name from [User] where username <> 'admin'";
      return DataProvider.Instance.ExecuteQuery(query);
    }
    public DataTable ShowData(int id)
    {
      string query = "SELECT s.Id_Station as N'Trạm', " +
                     "CAST(CASE WHEN usr.FK_Id_Station IS NOT NULL THEN '1' ELSE '0' END AS BIT) AS N'Phân quyền' FROM Station s " +
                     $"LEFT JOIN UserStationRole usr ON s.Id_Station = usr.FK_Id_Station AND usr.FK_Id_User = {id};";
      return DataProvider.Instance.ExecuteQuery(query);
    }
    public void DeleteData(int id)
    {
      try
      {
        string query = $"delete from UserStationRole where FK_Id_User = {id}";
        DataProvider.Instance.ExecuteNonQuery(query);
      }
      catch (SqlException ex)
      {
        MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
      }
    }
    public void AddData(int id, int item)
    {
      try
      {
        string query = $"insert into UserStationRole (FK_Id_User, FK_Id_Station) values ({id}, {item})";
        DataProvider.Instance.ExecuteNonQuery(query);
      }
      catch (SqlException ex)
      {
        MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
      }
    }
  }
}
