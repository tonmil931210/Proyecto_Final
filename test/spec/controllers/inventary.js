'use strict';

describe('Controller: InventaryCtrl', function () {

  // load the controller's module
  beforeEach(module('bodegaUninorteApp'));

  var InventaryCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    InventaryCtrl = $controller('InventaryCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(InventaryCtrl.awesomeThings.length).toBe(3);
  });
});
