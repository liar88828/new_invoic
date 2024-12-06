<?php
function toRupiah($price)
{
  return "Rp " . number_format($price, 0, ',', '.');
}