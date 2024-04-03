using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Models
{
    internal class ProcessContentPack
    {
        public decimal FK_Id_ContentPack { get; set; }
        public int FK_Id_Station { get; set; }
        public int FK_Id_State { get; set; }
        public string? Date_Start { get; set; }
        public string? Date_Fin { get; set; }
    }
}
