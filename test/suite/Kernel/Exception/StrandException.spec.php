<?php

declare (strict_types = 1); // @codeCoverageIgnore

namespace Recoil\Kernel\Exception;

use Eloquent\Phony\Phony;
use Error;
use Recoil\Strand;

describe(StrandException::class, function () {

    beforeEach(function () {
        $this->strand = Phony::mock(Strand::class);
        $this->strand->id->returns(123);
        $this->previous = new Error('<message>');

        $this->subject = new StrandException(
            $this->strand->get(),
            $this->previous
        );
    });

    it('implements the public api interface', function () {
        expect(
            is_subclass_of(
                StrandException::class,
                \Recoil\Exception\StrandException::class
            )
        )->to->be->true;
    });

    it('produces a useful message', function () {
        expect($this->subject->getMessage())->to->equal(
            'Unhandled exception in strand #123: Error (<message>).'
        );
    });

    it('exposes the failed strand', function () {
        expect($this->subject->strand())->to->equal($this->strand->get());
    });

    it('exposes the previous exception', function () {
        expect($this->subject->getPrevious())->to->equal($this->previous);
    });

});
