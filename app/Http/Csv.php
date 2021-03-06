<?php

namespace App\Http;

class Csv
{
	protected $records;
	protected $fileName;

	/**
	 * Csv constructor.
	 *
	 * @param $records
	 * @param $fileName
	 */
	public function __construct($records, $fileName)
	{
		$this->records  = $records;
		$this->fileName = $fileName;
	}

	/**
	 * Get all table attributes.
	 *
	 * @return array
	 */
	public function getAttributes()
	{
		return array_keys($this->records[0]->getAttributes());
	}

	/**
	 * Response header.
	 *
	 * @return string[]
	 */
	public function headers()
	{
		return [
			'Content-type'        => 'text/csv',
			'Content-Disposition' => "attachment; filename=\"{$this->fileName}.csv\"",
		];
	}

	/**
	 * Generate a CSV file.
	 *
	 * @return \Illuminate\Http\Response|mixed
	 */
	public function make()
	{
		$content    = '';
		$attributes = $this->getAttributes();

		foreach ($this->records as $record) {
			foreach ($attributes as $value) {
				if ($record->$value) {
					$content .= '"' . $record->$value . '"' . ', ';
				}
			}
			$content .= PHP_EOL;
		}

		return response()->make($content, $status = 200, $this->headers());
	}
}
