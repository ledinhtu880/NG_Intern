using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Models
{
    internal class DetailStateCellOfPackWareHouse
    {
        public int Rowi { get; set; }
        public int Colj { get; set; }
        public short FK_Id_StateCell { get; set; }
        public int FK_Id_Station { get; set; }
        public decimal FK_Id_PackContent { get; set; }
    }
}
