<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Wallet;
use App\Transfer;
class TransferTes extends TestCase
{


  //para vaciar bd en cada prueba
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPostTransfer()
    {


$wallet =factory(Wallet::class)->create();
$transfer=factory(Transfer::class)->make();
$response =$this->json('POST','/api/transfer',[
  'description'=>$transfer->description,
  'amount'=>$transfer->amount,
  'wallet_id'=>$wallet->id
]);

$response->assertJsonStructure([
  'id','description','amount','wallet_id'
])->assertStatus(201);


$response->asserDatabaseHas('transfers',[
  'description'=>$transfer->description,
  'amount'=>$transfer->amount,
  'wallet_id'=>$wallet->id
]);

$this->assertDatabaseHas('wallets',[
  'id'=>$wallet->id,
  'money'=>$wallet->money+$transfer->amout
]);
















    }
}
