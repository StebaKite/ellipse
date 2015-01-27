UPDATE paziente.vocelistino
SET qtaapplicazioni = qtaapplicazioni %operatore% 1,
    datamodifica = current_date
WHERE idvocelistino = %idvocelistino%
  AND idlistino = %idlistino%