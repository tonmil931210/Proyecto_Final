'use strict';

describe('Directive: navbarDirective', function () {

  // load the directive's module
  beforeEach(module('bodegaUninorteApp'));

  var element,
    scope;

  beforeEach(inject(function ($rootScope) {
    scope = $rootScope.$new();
  }));

  it('should make hidden element visible', inject(function ($compile) {
    element = angular.element('<navbar-directive></navbar-directive>');
    element = $compile(element)(scope);
    expect(element.text()).toBe('this is the navbarDirective directive');
  }));
});
