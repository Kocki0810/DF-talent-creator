import { Talent } from "./Talent.js";
export class Row {
    RowNumber;
    Placement;
    placeid;
    ChoiceNode;
    spell;
    connections;
    constructor(RowNumber, Placement, placeid, spell = new Talent(), ChoiceNode = 1, connections = [])
    {
      this.RowNumber = RowNumber;
      this.Placement = Placement;
      this.placeid = placeid;
      this.spell = spell;
      this.connections = connections;
    }
}