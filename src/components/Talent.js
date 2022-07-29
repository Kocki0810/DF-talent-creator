export class Talent {
    Name;
    Desc;
    RescourceCost = 0;
    RescourceType;
    SpellID = 0;
    points;
    image;

    constructor(name = "", desc = "", rCost = 0, rType = "mana", points = 1, image = "") 
    {
      this.Name = name;
      this.Desc = desc;
      this.RescourceCost = rCost;
      this.RescourceType = rType;
      this.points = points
    }
}