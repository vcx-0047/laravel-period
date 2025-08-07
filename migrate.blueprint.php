//this is not necessary
public function period()
    {
        return new Collection([
            $this->timestamp('period_start')->nullable(),
            $this->timestamp('period_end')->nullable(),
        ]);
    }
