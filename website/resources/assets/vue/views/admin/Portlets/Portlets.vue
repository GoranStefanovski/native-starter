<script setup>
  import { Portlet } from '@/components';
  import {
    PortletFoot, PortletBody, PortletHeadLabel, PortletHead, PortletHeadToolbar
  } from '@/components/Portlet/components';
  const loremIpsum = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.';
  const shortLoremIpsum = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing. Lorem Ipsum is simply dummy text of the printing.';
</script>

<template>
  <div class="row">
    <div class="col-lg-6">
      <Portlet>
        <PortletHead>
          <PortletHeadLabel>
            Basic Portlet <small>portlet sub title</small>
          </PortletHeadLabel>
        </PortletHead>
        <PortletBody>{{ loremIpsum }}</PortletBody>
      </Portlet>
      <Portlet>
        <PortletHead>
          <PortletHeadLabel :has-icon="true">
            Portlet with toolbar <small>portlet sub title</small>
          </PortletHeadLabel>
          <PortletHeadToolbar>
            <a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md">
              <i class="flaticon2-add-1"></i>
            </a>
            <a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md">
              <i class="flaticon2-maps"></i>
            </a>
            <a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md">
              <i class="flaticon2-power"></i>
            </a>
          </PortletHeadToolbar>
        </PortletHead>
        <PortletBody>{{ loremIpsum }}</PortletBody>
      </Portlet>
      <Portlet :is-bordered="true">
        <PortletHead>
          <PortletHeadLabel>
            Portlet with footer <small>portlet sub title</small>
          </PortletHeadLabel>
        </PortletHead>
        <PortletBody>{{ loremIpsum }}</PortletBody>
        <PortletFoot>
          <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
              Portlet footer:
            </div>
            <div class="col-lg-6 kt-align-right">
              <button type="submit" class="btn btn-brand">Submit</button>
              <span class="kt-margin-left-10">or <a href="#" class="kt-link kt-font-bold">Cancel</a></span>
            </div>
          </div>
        </PortletFoot>
      </Portlet>
    </div>
    <div class="col-lg-6">
      <Portlet :theme="'primary'">
        <PortletHead>
          <PortletHeadLabel>
            Solid skin
          </PortletHeadLabel>
        </PortletHead>
        <PortletBody>{{ loremIpsum }}</PortletBody>
      </Portlet>
      <Portlet :theme="'warning'">
        <PortletHead>
          <PortletHeadLabel>
            Solid warning skin
          </PortletHeadLabel>
        </PortletHead>
        <PortletBody>{{ loremIpsum }}</PortletBody>
        <PortletFoot>
          <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
              Portlet footer:
            </div>
            <div class="col-lg-6 kt-align-right">
              <a href="#" class="btn btn-font-light btn-outline-hover-light">Save</a>
              <a href="#" class="btn btn-font-light btn-outline-hover-light">Cancel</a>
            </div>
          </div>
        </PortletFoot>
      </Portlet>
      <Portlet :theme="'success'">
        <PortletHead>
          <PortletHeadLabel>
            Solid warning skin
          </PortletHeadLabel>
        </PortletHead>
        <PortletBody>{{ loremIpsum }}</PortletBody>
        <PortletFoot>
          <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
              Portlet footer:
            </div>
            <div class="col-lg-6 kt-align-right">
              <a href="#" class="btn btn-font-light btn-outline-hover-light">Save</a>
              <a href="#" class="btn btn-font-light btn-outline-hover-light">Cancel</a>
            </div>
          </div>
        </PortletFoot>
      </Portlet>
    </div>
    <div class="col-xl-4">
      <Portlet :is-equal-half-height="true">
        <PortletBody :is-equal-half-height="true">{{ shortLoremIpsum }}</PortletBody>
      </Portlet>
      <Portlet :is-equal-half-height="true">
        <PortletBody :is-equal-half-height="true">{{ shortLoremIpsum }}</PortletBody>
      </Portlet>
    </div>
    <div class="col-xl-4">
      <Portlet :is-equal-height="true">
        <PortletHead>
          <PortletHeadLabel>
            Same Height Portlet
          </PortletHeadLabel>
        </PortletHead>
        <PortletBody :is-equal-height="true">
          <span>{{ loremIpsum }}</span>
          <br />
          <span>{{ loremIpsum }}</span>
        </PortletBody>
      </Portlet>
    </div>
    <div class="col-xl-4">
      <Portlet :is-equal-height="true">
        <PortletHead>
          <PortletHeadLabel>
            Same Height Portlet
          </PortletHeadLabel>
        </PortletHead>
        <PortletBody :is-equal-height="true">
          <span>{{ shortLoremIpsum }}</span>
          <br />
          <span>{{ loremIpsum }}</span>
        </PortletBody>
      </Portlet>
    </div>
  </div>
</template>
