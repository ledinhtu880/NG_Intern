﻿using NganGiang.Libs;
using NganGiang.Models;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static Org.BouncyCastle.Math.EC.ECCurve;

namespace NganGiang.Services.Process
{
    internal class ProcessService410
    {
        public DataTable getProcessAt410()
        {
            string query = $"SELECT DCPOL.FK_Id_OrderLocal,\r\n\tPCP.FK_Id_ContentPack, S.Name_State,\r\n\tFORMAT(OL.Data_Start, 'dd-MM-yyyy') AS Data_Start\r\nFROM ProcessContentPack PCP\r\nINNER JOIN DetailContentPackOrderLocal DCPOL ON PCP.FK_Id_ContentPack = DCPOL.FK_Id_ContentPack\r\nINNER JOIN [State] S ON S.Id_State = PCP.FK_Id_State\r\nINNER JOIN OrderLocal OL ON OL.Id_OrderLocal = DCPOL.FK_Id_OrderLocal\r\nWHERE PCP.FK_Id_Station = 410 AND PCP.FK_Id_State = 0";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            return dt;
        }

        public DataTable getInforSimpleContentByContentPack(ContentPack contentPack)
        {
            return Helper.getInforSimpleContentByContentPack(contentPack);
        }

        private bool updateContentPack(ContentPack contentPack, out string message)
        {
            message = "";
            contentPack.HaveEilmPE = true;
            string query = $"UPDATE ContentPack SET HaveEilmPE = '{contentPack.HaveEilmPE}' WHERE Id_PackContent = {contentPack.Id_PackContent}";
            int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
            if (rowAffected <= 0)
            {
                message = "Cập nhật ContentPack thất bại";
                return false;
            }
            return true;
        }
        private bool updateProcessContentPack(ProcessContentPack processContentPack, out string message)
        {
            message = "";
            return Helper.updateProcessContentPack(processContentPack, out message);
        }
        private bool createProcessContentPack(ProcessContentPack processContentPack, out string message)
        {
            message = "";
            processContentPack.FK_Id_Station = 411;
            return Helper.createProcessContentPack(processContentPack, out message);
        }
        private bool createProcessContentSimple(ProcessContentPack processContentPack, out string message)
        {
            message = "";
            List<decimal> listIdContentSimples = Helper.getIdContentSimple(processContentPack, out message);

            foreach (decimal IdContentSimple in listIdContentSimples)
            {
                ProcessContentSimple processContentSimple = new ProcessContentSimple();
                processContentSimple.FK_Id_ContentSimple = IdContentSimple;
                processContentSimple.FK_Id_State = 0;
                processContentSimple.FK_Id_Station = 411;
                processContentSimple.Data_Start = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss");
                string query = $"INSERT INTO ProcessContentSimple(FK_Id_ContentSimple, FK_Id_State, FK_Id_Station, Data_Start) VALUES({processContentSimple.FK_Id_ContentSimple}, {processContentSimple.FK_Id_State}, {processContentSimple.FK_Id_Station}, '{processContentSimple.Data_Start}')";
                int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
                if (rowAffected <= 0)
                {
                    message = "Tạo ProcessContentSimple thất bại, Lỗi khi tạo FK_Id_ContentSimple";
                    return false;
                }
            }
            return true;
        }
        private bool updateProcessContentSimple(ProcessContentPack processContentPack, out string message)
        {
            List<decimal> listIdContentSimples = Helper.getIdContentSimple(processContentPack, out message);
            foreach (decimal IdContentSimple in listIdContentSimples)
            {
                ProcessContentSimple processContentSimple = new ProcessContentSimple();
                processContentSimple.FK_Id_ContentSimple = IdContentSimple;
                processContentSimple.FK_Id_State = 2;
                processContentSimple.FK_Id_Station = 410;
                processContentSimple.Data_Fin = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss");
                string query = $"UPDATE ProcessContentSimple SET FK_Id_State = {processContentSimple.FK_Id_State}, Data_Fin = '{processContentSimple.Data_Fin}' WHERE FK_Id_ContentSimple = {processContentSimple.FK_Id_ContentSimple} AND FK_Id_Station = {processContentSimple.FK_Id_Station}";
                int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
                if (rowAffected <= 0)
                {
                    message = "Cập nhật ProcessContentSimple thất bại tại thùng hàng số " + IdContentSimple;
                    return false;
                }
            }
            return true;
        }
        private bool updateDetailStateCellOfPackWareHouse(ContentPack contentPack, out string message)
        {
            message = "";
            DetailStateCellOfPackWareHouse detail = new DetailStateCellOfPackWareHouse();
            detail.FK_Id_PackContent = contentPack.Id_PackContent;
            detail.FK_Id_StateCell = 1;

            string query = $"UPDATE DetailStateCellOfPackWareHouse SET FK_Id_StateCell = {detail.FK_Id_StateCell}, FK_Id_PackContent = NULL WHERE FK_Id_PackContent = {contentPack.Id_PackContent}";
            int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
            if (rowAffected <= 0)
            {
                message = "Cập nhật DetailStateCellOfPackWareHouse thất bại";
                return false;
            }
            return true;
        }

        public bool processAt410(ContentPack contentPack, out string message)
        {
            if (!this.updateContentPack(contentPack, out message))
            {
                return false;
            }
            if (!this.updateDetailStateCellOfPackWareHouse(contentPack, out message))
            {
                return false;
            }
            ProcessContentPack processContentPack = new ProcessContentPack();
            processContentPack.FK_Id_ContentPack = contentPack.Id_PackContent;
            if (!this.updateProcessContentSimple(processContentPack, out message))
            {
                return false;
            }
            if (!this.updateProcessContentPack(processContentPack, out message))
            {
                return false;
            }
            if (!this.createProcessContentPack(processContentPack, out message))
            {
                return false;
            }
            if (!this.createProcessContentSimple(processContentPack, out message))
            {
                return false;
            }
            return true;
        }
    }
}