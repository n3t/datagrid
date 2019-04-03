<?php

declare(strict_types=1);

namespace Ublaboo\DataGrid\DataSource;

use Ublaboo\DataGrid\Filter\Filter;
use Ublaboo\DataGrid\Filter\FilterDate;
use Ublaboo\DataGrid\Filter\FilterDateRange;
use Ublaboo\DataGrid\Filter\FilterMultiSelect;
use Ublaboo\DataGrid\Filter\FilterRange;
use Ublaboo\DataGrid\Filter\FilterSelect;
use Ublaboo\DataGrid\Filter\FilterText;

abstract class FilterableDataSource
{

	/**
	 * {@inheritDoc}
	 *
	 * @param array<Filter> $filters
	 */
	public function filter(array $filters): void
	{
		foreach ($filters as $filter) {
			if ($filter->isValueSet()) {
				if ($filter->getConditionCallback() !== null) {
					($filter->getConditionCallback())($this->getDataSource(), $filter->getValue());
				} else {
					if ($filter instanceof FilterText) {
						$this->applyFilterText($filter);
					} elseif ($filter instanceof FilterMultiSelect) {
						$this->applyFilterMultiSelect($filter);
					} elseif ($filter instanceof FilterSelect) {
						$this->applyFilterSelect($filter);
					} elseif ($filter instanceof FilterDate) {
						$this->applyFilterDate($filter);
					} elseif ($filter instanceof FilterDateRange) {
						$this->applyFilterDateRange($filter);
					} elseif ($filter instanceof FilterRange) {
						$this->applyFilterRange($filter);
					}
				}
			}
		}
	}


	/**
	 * @return mixed
	 */
	abstract protected function getDataSource();

	abstract protected function applyFilterDate(FilterDate $filter): void;

	abstract protected function applyFilterDateRange(FilterDateRange $filter): void;

	abstract protected function applyFilterRange(FilterRange $filter): void;

	abstract protected function applyFilterText(FilterText $filter): void;

	abstract protected function applyFilterMultiSelect(FilterMultiSelect $filter): void;

	abstract protected function applyFilterSelect(FilterSelect $filter): void;
}
