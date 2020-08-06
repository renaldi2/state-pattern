<?php

class Context
{

    private $state;
    
    public function __construct(State $state)
    {
        $this->transitionTo($state);
    }

    public function transitionTo(State $state): void
    {
        echo "Context: pesanan belum jadi.\n<br>";
        $this->state = $state;
        $this->state->setContext($this);
		
    }
	 public function transitionTo1(State $state): void
    {
        echo "Context: pesanan sedang dibuat.\n<br>";
        $this->state = $state;
        $this->state->setContext($this);
    }
	 public function transitionTo2(State $state): void
    {
        echo "Context: pesanan siap disajikan.\n<br>";
        $this->state = $state;
        $this->state->setContext($this);
    }
    public function request1(): void
    {
        $this->state->handle1();
    }

    public function request2(): void
    {
        $this->state->handle2();
    }
}

abstract class State
{

    protected $context;

    public function setContext(Context $context)
    {
        $this->context = $context;
    }

    abstract public function handle1(): void;

    abstract public function handle2(): void;
}

class ConcreteStateA extends State
{
    public function handle1(): void
    {
        echo "ConcreteStateA menangani request1.\n<br>";
        echo "ConcreteStateA ingin mengubah keadaan konteks.\n<br>";
        $this->context->transitionTo1(new ConcreteStateB);
    }

    public function handle2(): void
    {
        echo "ConcreteStateA handles request2.\n<br>";
    }
}

class ConcreteStateB extends State
{
    public function handle1(): void
    {
        echo "ConcreteStateB handles request1.\n<br>";
    }

    public function handle2(): void
    {
        echo "ConcreteStateB menangani request2.\n<br>";
        echo "ConcreteStateB ingin mengubah keadaan konteks.\n<br>";
        $this->context->transitionTo2(new ConcreteStateA);
    }
}

$context = new Context(new ConcreteStateA);
$context->request1();
$context->request2();