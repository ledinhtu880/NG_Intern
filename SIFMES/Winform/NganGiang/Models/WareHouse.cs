using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Models
{
    internal class WareHouse
    {
        public int FK_Id_Station { get; set; }
        public int numRow { get; set; }
        public int numCol { get; set; }

        public WareHouse(int numRow, int numCol)
        {
            this.numRow = numRow;
            this.numCol = numCol;
        }
        public WareHouse(int FK_Id_Station)
        {
            this.FK_Id_Station = FK_Id_Station;
        }
    }
}
