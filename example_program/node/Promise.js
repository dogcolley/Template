function getId(phoneNumber) { /* … */ }
function getEmail(id) { /* … */ }
function getName(email) { /* … */ }
function order(name, menu) { /* … */ }

function orderCoffee(phoneNumber) {
    return getId(phoneNumber).then(function(id) {
        return getEmail(id);
    }).then(function(email) {
        return getName(email);
    }).then(function(name) {
        return order(name, 'coffee');
    });
}

function* orderCoffeeG(phoneNumber) {
    const id = yield getId(phoneNumber);
    const email = yield getEmail(id);
    const name = yield getName(email);
    const result = yield order(name, 'coffee');
    return result;
}