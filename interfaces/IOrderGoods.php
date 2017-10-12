<?php
namespace interfaces;
interface IOrderGoods
{
	public function getTotalGoodsQuantity(); // return Int
	public function getTotalSum(); // return Float
}