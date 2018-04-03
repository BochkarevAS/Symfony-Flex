class Helper {
    constructor(count) {
        this.count = count;
    }

    calculateTotalWeight() {
        let totalWeight = 0;
        for (let element of this.count) {
            totalWeight += element;
        }
        return totalWeight;
    }
}

module.exports = Helper;