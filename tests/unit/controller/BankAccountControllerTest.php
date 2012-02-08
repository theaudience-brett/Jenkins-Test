<?php
/**
 * @small
 */
class BankAccountControllerTest extends ControllerTestCase
{
    /**
     * @covers BankAccountController::__construct
     */
    protected function setUp()
    {
        parent::setUp();
        $this->controller = new BankAccountController($this->mapper);
    }

    /**
     * @covers BankAccountController::execute
     */
    public function testReturnsBankAccountViewWhenBankAccountIsSpecified()
    {
        $this->request->expects($this->once())
                      ->method('get')
                      ->with($this->equalTo('id'))
                      ->will($this->returnValue(1));

        $this->mapper->expects($this->any())
                     ->method('findById')
                     ->will($this->returnValue(new BankAccount));

        $this->response->expects($this->at(0))
                       ->method('set')
                       ->with($this->equalTo('id'),
                              $this->equalTo(1));

        $this->response->expects($this->at(1))
                       ->method('set')
                       ->with($this->equalTo('balance'),
                              $this->equalTo(0));

        $view = $this->controller->execute($this->request, $this->response);

        $this->assertEquals('BankAccountView', $view);
    }

    /**
     * @covers            BankAccountController::execute
     * @covers            ControllerException
     * @expectedException ControllerException
     */
    public function testExceptionIsRaisedWhenBankAccountIsNotSpecified()
    {
        $this->request->expects($this->once())
                      ->method('get')
                      ->with($this->equalTo('id'))
                      ->will($this->throwException(new OutOfBoundsException));

        $this->controller->execute($this->request, $this->response);
    }

    /**
     * @covers            BankAccountController::execute
     * @covers            ControllerException
     * @expectedException ControllerException
     */
    public function testExceptionIsRaisedWhenBankAccountIsNotFound()
    {
        $this->request->expects($this->once())
                      ->method('get')
                      ->with($this->equalTo('id'))
                      ->will($this->returnValue(3));

        $this->mapper->expects($this->any())
                     ->method('findById')
                     ->will($this->throwException(new OutOfBoundsException));

        $this->controller->execute($this->request, $this->response);
    }
}
