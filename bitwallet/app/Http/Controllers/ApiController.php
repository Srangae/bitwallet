<?php


	namespace App\Http\Controllers;


	use App\Exceptions\GeneralException;
    use App\Services\TickerService;
    use Exception;
    use GuzzleHttp\Client;

    class ApiController extends Controller
	{
        const BINANCE = 'https://api.binance.com/api/v3/ticker/price';

        const BITTREX = 'https://api.bittrex.com/api/v1.1/public/getticker';

        /**
         * @var Client
         */
        private $client;
        /**
         * @var TickerService
         */
        private $tickerService;

        public function __construct(Client $client, TickerService $tickerService)
        {
            $this->client = $client;
            $this->tickerService = $tickerService;
	    }

        /**
         * Example using postman
         * request [ 'symbol' => 'ETHBTC'] - specific ticker
         *
         * Leave request empty for full list.
         *
         */
        public function getTickerPair()
        {
            $result = $this->requestTicker(self::BINANCE, ['symbol' => request('symbol')]);

            return $result->getBody()->getContents();
	    }

        /**
         * Use LTCBTC and BTC-LTC for this test because different API have different tickers
         */
        public function bestTickerPrice()
        {
            $binanceResult = $this->requestTicker(self::BINANCE, ['symbol' => request('binance_query')]);
            $bittrexResult = $this->requestTicker(self::BITTREX, ['market' => request('bittrex_query')]);

            return  $this->tickerService->bestPriceForTicker($binanceResult, $bittrexResult);

	    }

        private function requestTicker($serviceProvider, $query)
        {
            try{
                return $this->client->request('GET', $serviceProvider, ['query' => $query]);
            }catch(Exception $exception){
                throw new GeneralException($exception);
            }
	    }

	}
