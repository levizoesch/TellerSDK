<?php

namespace TellerSDK\Tests;
use TellerSDK\Exceptions\MissingAccessTokenException;
use TellerSDK\Exceptions\MissingTellerConfigurationException;
use TellerSDK\TellerClient;

class TellerClientTest extends BaseTest
{

    public function testConfigMatchesEnv()
    {
        $envToken = getenv('TELLER_TEST_TOKEN');
        $confToken = config('teller.TEST_TOKEN');

        $this->assertSame($envToken,$confToken);
    }


    /**
    * @throws MissingAccessTokenException
    */
    public function testListAccounts()
    {
        $token = config('teller.TEST_TOKEN');
        $teller = new TellerClient($token);
        $result = $teller->listAccounts();
        $this->assertIsArray($result);
    }

    public function testListAccountBalances()
    {
        $token = config('teller.TEST_TOKEN');
        $teller = new TellerClient($token);
        $result = $teller->listAccounts();
        $accountId = $result[0]->id;
        $teller->getAccountBalances($accountId);
    }

    public function testListAccountsMissingAccessTokenExceptionThrown()
    {
        $token = null;
        $this->expectException(MissingAccessTokenException::class);
        $teller = new TellerClient($token);
    }

    public function testTellerTestTokenIsDefined()
    {
        $token = getenv('TELLER_TEST_TOKEN');
        $this->assertIsString($token);
    }

    public function testMissingTellerConfigurationExceptionThrown() {
        $this->expectException(MissingTellerConfigurationException::class);

        throw new MissingTellerConfigurationException();
    }

}
