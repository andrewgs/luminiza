/*  Author: Reality Group
 *  http://realitygroup.ru/
 */


var tours = {
    1: {
      	cprice : function(price,adults,children,infants){
			var people = adults+children+infants;
			if(people <= 4){
				return Math.floor(parseFloat(price*4));
			}else{
				people = adults+(children*0.5);
				return Math.floor(parseFloat(price*people));
			}
		},
		name : "�������� ��������� �� ������� ��������",
		message: function(){alert(this.name)}
    },
	2: {
      	cprice : function(price,adults,children,infants){return price;},
		cpeople : function(adults,children,infants){return true;},
		name : "���� ���� ��������",
		message: function(){alert(this.name)}
    },
	3: {
      	cprice : function(price,adults,children,infants){
			var people = adults+children+infants;
			if(people <= 4){
				return Math.floor(parseFloat(price*4));
			}else{
				people = adults+(children*0.5);
				return Math.floor(parseFloat(price*people));
			}
		},
		name : "��������� �� ������ ����� (El Teide)",
		message: function(){alert(this.name)}
    },
	4: {
      	cprice : function(price,adults,children,infants){
			var people = adults+(children*0.5);
			return Math.floor(parseFloat(price*people));
		},
		name : "��������� �� ������� �� ������",
		message: function(){alert(this.name)}
    },
	5: {
      	cprice : function(price,adults,children,infants){
			var people = adults+(children*0.5);
			return Math.floor(parseFloat(price*people));
		},
		name : "��������� �� ������� ���� �������",
		message: function(){alert(this.name)}
    }
};