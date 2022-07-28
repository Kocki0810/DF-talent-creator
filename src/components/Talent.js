export class Talent {
    Name;
    Desc;
    RescourceCost = 0;
    RescourceType;
    SpellID = 0;

    constructor(name = "", desc = "", rCost = 0, rType = "mana") 
    {
      this.Name = name;
      this.Desc = desc;
      this.RescourceCost = rCost;
      this.RescourceType = rType;
    }
}