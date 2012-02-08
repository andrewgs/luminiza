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
		name : "Обзорная экскурсия по острову Тенерифе",
		message: function(){alert(this.name)}
    },
	2: {
      	cprice : function(price,adults,children,infants){return 150;},
		name : "Лоро Парк Тенерифе",
		message: function(){alert(this.name)}
    },
	3: {
      	cprice : function(price,adults,children,infants){
		
			return Math.floor(parseFloat(price*people));
		},
		name : "tour name number 3",
		message: function(){alert(this.name)}
    },
	4: {
      	cprice : function(price,adults,children,infants){
		
			return Math.floor(parseFloat(price*people));
		},
		name : "tour name number 4",
		message: function(){alert(this.name)}
    },
	5: {
      	cprice : function(price,adults,children,infants){
		
			return Math.floor(parseFloat(price*people));
		},
		name : "tour name number 5",
		message: function(){alert(this.name)}
    }
};