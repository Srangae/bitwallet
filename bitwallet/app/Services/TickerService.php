<?php

    namespace App\Services;

	class TickerService
	{
        public function bestPriceForTicker($binance, $bittrex)
        {
            $priceCollection = collect([
                ['name' => 'binance', 'price' => (float)$this->getBinancePrice($binance)],
                ['name' => 'bittrex', 'price' => (float)$this->getBittrexPrice($bittrex)]
            ]);

            return $priceCollection->sortByDesc('price');

	    }

        private function getBinancePrice($binance)
        {
            return json_decode($binance->getBody()->getContents())->price;
	    }

        private function getBittrexPrice($bittrex)
        {
            return json_decode($bittrex->getBody()->getContents())->result->Last;
	    }
	}
