'use strict';

describe('Controller: NavbarctrlCtrl', function () {

  // load the controller's module
  beforeEach(module('bodegaUninorteApp'));

  var NavbarctrlCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    NavbarctrlCtrl = $controller('NavbarctrlCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(NavbarctrlCtrl.awesomeThings.length).toBe(3);
  });
});
