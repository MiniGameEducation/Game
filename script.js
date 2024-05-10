function calculateIntegerPlusInteger(A, B) {

    const intValueA = parseInt(A);
    const intValueB = parseInt(B);        
    
    if (isNaN(intValueA) || isNaN(intValueB)) {
        return "A or B is not a valid integer.";
    }

   
    const result = intValueA + intValueB;

    return result;
}

const integerA = 10;
const integerB = 5; 

const hasil = calculateIntegerPlusInteger(integerA, integerB);
console.log(hasil); 