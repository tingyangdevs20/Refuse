@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->

    <section class="StyledDialog-c11n-8-84-3__sc-3phm7o-0 iotCst StyledDropdown-c11n-8-84-3__sc-lz45p2-0 hMWkrB"
        role="dialog"
        style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(16px, 203px, 0px);"
        data-popper-placement="bottom-start">
        <ul aria-multiselectable="false" id="__c11n_22q1cb" role="listbox"
            class="StyledListbox-c11n-8-84-3__sc-1vo0dzk-0 fnKuTe" aria-activedescendant="__c11n_22q2i4">
            <li aria-selected="false" data-active="false" id="__c11n_22q2hz"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$0</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2i0"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$50,000
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2i1"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$100,000
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2i2"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$150,000
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2i3"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$200,000
                </div>
            </li>
            <li aria-selected="false" data-active="true" id="__c11n_22q2i4"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$250,000
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2i5"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">
                    $300,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2i6"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">
                    $350,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2i7"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">
                    $400,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2i8"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">
                    $450,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2i9"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">
                    $500,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2ia"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">
                    $550,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2ib"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">
                    $600,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2ic"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">
                    $650,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2id"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">
                    $700,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2ie"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">
                    $750,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2if"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">
                    $800,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2ig"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">
                    $850,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2ih"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">
                    $900,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2ii"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">
                    $950,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2ij"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$1M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2ik"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$1.25M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2il"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$1.5M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2im"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$1.75M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2in"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$2M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2io"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$2.25M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2ip"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$2.5M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2iq"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$2.75M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2ir"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$3M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2is"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$3.25M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2it"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$3.5M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2iu"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$3.75M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2iv"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$4M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2iw"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$4.25M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2ix"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$4.5M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2iy"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$4.75M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2iz"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$5M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2j0"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$6M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2j1"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$7M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2j2"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$8M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2j3"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$9M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2j4"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$10M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2j5"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$11M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2j6"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$12M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2j7"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$13M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2j8"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$14M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2j9"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$15M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2ja"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$16M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2jb"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$17M
                </div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2jc"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$18M
                </div>
            </li>
        </ul>
    </section>

    <section class="StyledDialog-c11n-8-84-3__sc-3phm7o-0 iotCst StyledDropdown-c11n-8-84-3__sc-lz45p2-0 hMWkrB"
        role="dialog"
        style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(210px, 203px, 0px);"
        data-popper-placement="bottom-start">
        <ul aria-multiselectable="false" id="__c11n_22q1ds" role="listbox"
            class="StyledListbox-c11n-8-84-3__sc-1vo0dzk-0 fnKuTe" aria-activedescendant="__c11n_22q2vx">
            <li aria-selected="false" data-active="false" id="__c11n_22q2vu"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$50,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2vv"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$100,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2vw"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$150,000</div>
            </li>
            <li aria-selected="false" data-active="true" id="__c11n_22q2vx"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$200,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2vy"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$250,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2vz"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$300,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2w0"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$350,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2w1"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$400,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2w2"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$450,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2w3"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$500,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2w4"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$550,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2w5"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$600,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2w6"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$650,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2w7"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$700,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2w8"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$750,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2w9"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$800,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wa"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$850,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wb"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$900,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wc"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$950,000</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wd"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$1M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2we"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$1.25M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wf"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$1.5M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wg"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$1.75M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wh"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$2M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wi"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$2.25M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wj"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$2.5M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wk"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$2.75M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wl"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$3M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wm"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$3.25M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wn"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$3.5M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wo"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$3.75M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wp"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$4M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wq"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$4.25M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wr"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$4.5M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2ws"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$4.75M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wt"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$5M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wu"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$6M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wv"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$7M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2ww"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$8M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wx"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$9M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wy"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$10M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2wz"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$11M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2x0"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$12M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2x1"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$13M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2x2"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$14M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2x3"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$15M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2x4"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$16M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2x5"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$17M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2x6"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">$18M</div>
            </li>
            <li aria-selected="false" data-active="false" id="__c11n_22q2x7"
                class="StyledListboxOption-c11n-8-84-3__sc-1f5r1cg-0 ijjalL StyledComboboxOption-c11n-8-84-3__sc-brr3vr-0 kJQDoo"
                role="option">
                <div class="ListboxOptionLabel-c11n-8-84-3__sc-wlbymz-0 lbyMcY">Any Price</div>
            </li>
        </ul>
    </section>

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Data Management</h4>

                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            Edit Data
                            <a href="{{ URL::previous() }}" class="btn btn-outline-primary btn-sm float-right ml-2"
                                title="New"><i class="fas fa-arrow-left"></i></a>
                            @include('components.modalform')
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.scraping.update', @$scrapingdata->id) }}"
                                enctype="multipart/form-data">
                                @csrf <!-- CSRF Token -->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" class="form-control @error('country') is-invalid @enderror"
                                            id="country" name="country"
                                            value="{{ old('country', $scrapingdata->country) }}">
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control @error('state') is-invalid @enderror"
                                            id="state" name="state"
                                            value="{{ old('state', $scrapingdata->state) }}">
                                        @error('state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror"
                                            id="city" name="city" value="{{ old('city', $scrapingdata->city) }}">
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="zip">Zip</label>
                                        <input type="number" class="form-control @error('zip') is-invalid @enderror"
                                            id="zip" name="zip"
                                            value="{{ old('zip', $scrapingdata->zip_code) }}">
                                        @error('zip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="listing_type">Listing Type</label>
                                        <select class="form-control @error('listing_type') is-invalid @enderror"
                                            id="listing_type" name="listing_type[]" multiple>
                                            <option value="owner"
                                                {{ in_array('owner', (array) $scrapingdata->listing_type) ? 'selected' : '' }}>
                                                For Sale (by Owner)</option>
                                            <option value="agent"
                                                {{ in_array('agent', (array) $scrapingdata->listing_type) ? 'selected' : '' }}>
                                                Sale (By Agent)</option>
                                        </select>
                                        @error('listing_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>




                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price_range">Price Range</label>
                                        <select class="form-control @error('price_range') is-invalid @enderror"
                                            id="price_range" name="price_range">
                                            <option value="">Select Price Range</option>
                                            <option value="100k-300k"
                                                {{ $scrapingdata->price_range == '100k-300k' ? 'selected' : '' }}>100k-300k
                                            </option>
                                            <option value="300k-600k"
                                                {{ $scrapingdata->price_range == '300k-600k' ? 'selected' : '' }}>300k-600k
                                            </option>

                                        </select>
                                        @error('price_range')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_of_bedrooms">No of Bedrooms</label>
                                        <select class="form-control @error('no_of_bedrooms') is-invalid @enderror"
                                            id="no_of_bedrooms" name="no_of_bedrooms">
                                            <option value="">Select No of Bedrooms</option>
                                            <option value="1"
                                                {{ $scrapingdata->no_of_bedrooms == '1' ? 'selected' : '' }}>1</option>
                                            <option value="2"
                                                {{ $scrapingdata->no_of_bedrooms == '2' ? 'selected' : '' }}>2</option>
                                            <option value="3"
                                                {{ $scrapingdata->no_of_bedrooms == '3' ? 'selected' : '' }}>3</option>
                                            <option value="4"
                                                {{ $scrapingdata->no_of_bedrooms == '4' ? 'selected' : '' }}>4</option>
                                            <option value="5"
                                                {{ $scrapingdata->no_of_bedrooms == '5' ? 'selected' : '' }}>5</option>

                                        </select>
                                        @error('no_of_bedrooms')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_of_bathrooms">No of bathrooms</label>
                                        <select class="form-control @error('no_of_bathrooms') is-invalid @enderror"
                                            id="no_of_bathrooms" name="no_of_bathrooms">
                                            <option value="">Select No of Bedrooms</option>
                                            <option value="1"
                                                {{ $scrapingdata->no_of_bathrooms == '1' ? 'selected' : '' }}>1</option>
                                            <option value="2"
                                                {{ $scrapingdata->no_of_bathrooms == '2' ? 'selected' : '' }}>2</option>
                                            <option value="3"
                                                {{ $scrapingdata->no_of_bathrooms == '3' ? 'selected' : '' }}>3</option>
                                            <option value="4"
                                                {{ $scrapingdata->no_of_bathrooms == '4' ? 'selected' : '' }}>4</option>
                                            <option value="5"
                                                {{ $scrapingdata->no_of_bathrooms == '5' ? 'selected' : '' }}>5</option>

                                        </select>
                                        @error('no_of_bathrooms')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="property_type">Property Type</label>
                                        <select class="form-control @error('property_type') is-invalid @enderror"
                                            id="property_type" name="property_type[]" multiple>
                                            <option value="">Property Type</option>
                                            <option value="Houses"
                                                {{ in_array('Houses', (array) $scrapingdata->property_type) ? 'selected' : '' }}>
                                                Houses</option>
                                            <option value="Townhomes"
                                                {{ in_array('Townhomes', (array) $scrapingdata->property_type) ? 'selected' : '' }}>
                                                Townhomes</option>
                                            <option value="Multi-Family"
                                                {{ in_array('Multi-Family', (array) $scrapingdata->property_type) ? 'selected' : '' }}>
                                                Multi-Family</option>
                                            <option value="Condos/Co-ops"
                                                {{ in_array('Condos/Co-ops', (array) $scrapingdata->property_type) ? 'selected' : '' }}>
                                                Condos/Co-ops</option>
                                            <option value="Lots/Land"
                                                {{ in_array('Lots/Land', (array) $scrapingdata->property_type) ? 'selected' : '' }}>
                                                Lots/Land</option>
                                            <option value="Apartments"
                                                {{ in_array('Apartments', (array) $scrapingdata->property_type) ? 'selected' : '' }}>
                                                Apartments</option>
                                            <option value="Manufactured"
                                                {{ in_array('Manufactured', (array) $scrapingdata->property_type) ? 'selected' : '' }}>
                                                Manufactured</option>
                                        </select>
                                        @error('property_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="filters">Filters</label>
                                        <select class="form-control @error('filters') is-invalid @enderror" id="filters"
                                            name="filters">
                                            <option value="">Filter</option>
                                            <option value="pre-foreclousers"
                                                {{ $scrapingdata->filters == 'pre-foreclousers' ? 'selected' : '' }}>Pre
                                                Foreclousers</option>
                                            <option value="coming-soon"
                                                {{ $scrapingdata->filters == 1 ? 'selected' : 'coming-soon' }}>Coming Soon
                                            </option>

                                        </select>
                                        @error('filters')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_name">Job Name</label>
                                        <input type="text"
                                            class="form-control @error('job_name') is-invalid @enderror" id="job_name"
                                            name="job_name" value="{{ old('job_name', $scrapingdata->job_name) }}">
                                        @error('job_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="data_status">Status</label>
                                        <select class="form-control @error('data_status') is-invalid @enderror"
                                            id="data_status" name="data_status">
                                            <option value="">Select Status</option>
                                            <option value="1"
                                                {{ $scrapingdata->data_status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0"
                                                {{ $scrapingdata->data_status == 0 ? 'selected' : '' }}>Inactive</option>

                                        </select>
                                        @error('data_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="file">File</label>
                                        <input type="file"
                                            class="form-control-file @error('file') is-invalid @enderror" id="file"
                                            name="file">
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Update Data</button>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
            $('select').select2();

        });
    </script>
    <script></script>
@endsection
