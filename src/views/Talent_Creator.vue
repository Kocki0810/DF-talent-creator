<template>
  <div>
    <div>
      <h1>Create Spells</h1>
      <textarea class="ability-desc" v-model="spellDesc" placeholder="Type Description here"></textarea>
      <textarea class="ability-desc" v-model="SpellID" placeholder="Type Spell ID here"></textarea>
      <br>
      <button @click="addSpell(); counter++">Add Spell</button>
    </div>
    <div class="drop-zone" @drop="onDropSpellArea($event, spell)">
      <div class="ability" draggable @dragstart="startDrag($event, spell) " v-for="spell in this.spells" :key="spell.SpellID">
        {{spell.SpellID}}
      </div>
    </div>
    <div class="talent_tree">
  <br><br>
      
    </div>
    
    <div>
      <div v-for="x in this.class_rows" :key="x.id" class="talentrow">
        <div class="drop-zone">
          <div v-for="y in x.fields" :key="y.iterator" class="drop-zone" v-on:click="start_connection(y)" @drop="onDrop($event, y.RowNumber, y.Placement, 'class')" @dragover.prevent @dragenter.prevent>
            <span v-if="y.connections[0] != undefined && y.connections[0] != undefined">
            {{ y.connections[0].RowNumber + " - " + y.connections[0].Placement}}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {Talent} from '../components/Talent.js'
import {Row} from '../components/Row.js'
import $ from 'jquery'

export default {
  name: 'app',
  data () {
    return {
        class_rows: [],
        spec_rows: [],
        spells : [],
        spellDesc: "",
        counter: 1,
        SpellID: "",
        SpellData: "",
        connection_active: false,
        connect_from: null
    }
  },
  methods: {
    logmsg(msg)
    {
      console.log(msg);
    },
    start_connection(row)
    {
      if(this.connection_active && this.connect_from != row)
      {
          this.connection_active = false;
          this.connect_from.connections.push(row);
          this.connect_from = "";
      }
      else
      {
        this.connection_active = true;
        this.connect_from = row;
      }
    },
    addSpell()
    {
      if(this.SpellID != "")
      {
        while(this.SpellID == "")
        {
          this.getSpellData(this.SpellID);
        }
        var apiData = JSON.parse(this.SpellData);
        var talent = new Talent();
        talent.image = apiData.media.key.href;
        talent.Name = apiData.name;
        talent.Desc = apiData.description;
      }
      else
      {
        var talent = new Talent("", desc.text);
        this.spells.push(talent);
        talent.SpellID = this.counter;
      }
    },
    startDrag(evt, spell)
    {
      evt.dataTransfer.dropEffect = "move";
      evt.dataTransfer.effectAllowed = "move";
      evt.dataTransfer.setData("spell", JSON.stringify(spell));
    },
    onDrop(evt, x, y, row)
    {
      var spell = JSON.parse(evt.dataTransfer.getData("spell"));
      this.class_rows[x-1].fields[y-1].spell = spell;
    },
    onDropSpellArea(evt, x, y, row)
    {
      const spellID = evt.dataTransfer.getData("spellID");
      const spell = this.spells.find(({spellID}) => spellID == spellID);
      this.class_rows[x-1].fields[y-1].spell = spellID;
    },
    makeRows()
    {
      var iterator = 0;
      var i = 1;
      var j = 1;
      for(i = 1; i <= 10; i++)
      {
        var temp = {
          id: i,
          fields: []
        }
        this.class_rows.push(temp);
        this.spec_rows.push(temp);
        for(j = 1; j <= 9; j++)
        {
          this.class_rows[iterator].fields.push(new Row(i,j));
          // this.spec_rows[iterator].fields.push(new Row(i,j));
        }
        iterator++;
      }
      console.clear();
    },
    getSpellData(SpellID)
    {
      $.ajax({
        url: "http://localhost/DF_Talents/getspellinfo.php",
        type: "GET",
        data: {"spellid": SpellID},
        success: function(html){
          this.SpellData = html;
        }
      });
    }
  },
  beforeMount()
  {
    this.makeRows();
  }
  
}

</script>
<style>
.ability{
  background-color: black;
  border: 5px solid pink;
  width: 50px;
  height:50px;
  display: inline-block;
  color: red;
}
.drop-zone {  
  background-color: #eee;  
  margin-bottom: 10px;  
  padding: 10px;
  width: 60px;
  height: 60px;
  display: inline;
  }
.drag-el {  background-color: #fff;  margin-bottom: 10px;  padding: 5px;}
.talentrow{
  height: 70px;
}
</style>
