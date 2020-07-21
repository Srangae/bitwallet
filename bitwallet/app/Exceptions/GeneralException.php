<?php


	namespace App\Exceptions;


	use Exception;

    class GeneralException extends Exception
	{
        private $exception;

        public function __construct($exception)
        {
            parent::__construct();
            $this->exception = $exception;
	    }

        public function render()
        {
            #check for HTTP Error 429
            if($this->exception->getCode() === 429) {
                return response()->json([
                                            'error' => true,
                                            'message' => 'Please try again after 30 minutes to prevent IP Ban'
                                        ]);
            }

            return response()->json([
                                        'error' => true,
                                        'message' => 'Unexpected error encountered.'
                                    ]);
	    }
	}
